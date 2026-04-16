<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentTask;
use App\Models\ContentBrief;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RevisionController extends Controller
{
    /**
     * Daftar konten dengan status under_review dan need_revision
     */
    public function index()
    {
        // Revision shows items that are under_review, need_revision, or terevisi.
        $workflowStatuses = ['under_review', 'need_revision', 'terevisi'];

        $contentTasks = ContentTask::with(['brand', 'creator', 'productions' => function($q) {
                $q->latest()->limit(1);
            }])
            ->whereIn('status', $workflowStatuses)
            ->where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();

        // Statistics dari content_tasks.status
        $stats = [
            'total_review' => ContentTask::where('user_id', Auth::id())->whereIn('status', $workflowStatuses)->count(),
            'under_review' => ContentTask::where('user_id', Auth::id())->where('status', 'under_review')->count(),
            'need_revision' => ContentTask::where('user_id', Auth::id())->where('status', 'need_revision')->count(),
            'terevisi' => ContentTask::where('user_id', Auth::id())->where('status', 'terevisi')->count(),
        ];

        return view('admin.revision.index', compact('contentTasks', 'stats'));
    }

    /**
     * Notify creator about revision via email
     */
    public function notifyRevision($id)
    {
        $task = ContentTask::where('user_id', Auth::id())->findOrFail($id);
        
        // Find brief to get creator email and token
        $brief = ContentBrief::where('user_id', Auth::id())
            ->where('title', $task->judul_konten)
            ->where('brand_id', $task->brand_id)
            ->first();

        if (!$brief || !$brief->creator_email) {
            return response()->json([
                'success' => false,
                'message' => 'Email kreator tidak ditemukan di data brief.',
            ], 422);
        }

        try {
            $emailData = [
                'title' => $task->judul_konten,
                'brand' => $brief->brand->name ?? '-',
                'revision_note' => $task->revision_note,
                'deadline' => $task->revision_deadline ? $task->revision_deadline->format('d M Y') : '-',
                'upload_link' => route('brief.public', ['token' => $brief->token, 'tab' => 'upload']),
                'reply_to' => Auth::user()->email
            ];

            \Illuminate\Support\Facades\Mail::to($brief->creator_email)->send(new \App\Mail\RevisionNotification($emailData));

            $mailHint = null;
            $currentMailer = config('mail.default');
            if ($currentMailer === 'log') {
                $mailHint = 'Catatan: Mailer saat ini diatur ke "log". Email hanya akan muncul di storage/logs/laravel.log. Untuk mengirim ke Inbox asli, ubah MAIL_MAILER=smtp di file .env.';
            } elseif ($currentMailer === 'failover') {
                $mailHint = 'Catatan: Mailer diatur ke "failover" (mencoba SMTP lalu Sendmail). Jika email tidak diterima, pastikan kredensial SMTP di .env sudah benar atau periksa folder spam.';
            }

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi revisi berhasil dikirim ke ' . $brief->creator_email,
                'mail_hint' => $mailHint
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload revision video/image
     */
    public function uploadRevision(Request $request)
    {
        $request->validate([
            'content_task_id' => 'required|exists:content_tasks,id',
            'video_file' => 'required|file|mimes:mp4,mov,avi,mkv,m4v,wmv,flv,mpeg,mpg,mpe,3gp,3g2,ogv,ts,m2ts,asf,f4v,jpg,jpeg,png|max:500000',
        ]);

        $task = ContentTask::where('user_id', Auth::id())->findOrFail($request->content_task_id);

        try {
            $file = $request->file('video_file');
            $fileName = time() . '_rev_' . $task->id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('productions', $fileName, 'public');

            // Find brief to link
            $brief = ContentBrief::where('user_id', Auth::id())
                ->where('title', $task->judul_konten)
                ->where('brand_id', $task->brand_id)
                ->first();

            // Create new production record for the revision
            $production = \App\Models\Production::create([
                'brief_id' => $brief ? $brief->id : null,
                'content_task_id' => $task->id,
                'judul_konten' => $task->judul_konten,
                'versi_video' => 'Revision',
                'durasi_final' => '-', // Will be updated if needed
                'file_video' => $filePath,
                'status' => 'pending', // Pending approval of this revision
                'user_id' => Auth::id(),
            ]);

            // Update task status to terevisi
            $task->update(['status' => 'terevisi']);

            return response()->json([
                'success' => true,
                'message' => 'Hasil revisi berhasil diunggah. Status sekarang "Terevisi".',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah revisi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send to Approval: update status → ready_to_publish
     * (disamakan dengan halaman Approval & Publishing agar kartu/stat sinkron)
     */
    public function sendToApproval(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada konten yang dipilih.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            ContentTask::where('user_id', Auth::id())
                ->whereIn('id', $ids)
                ->whereIn('status', ['under_review', 'need_revision', 'terevisi'])
                ->update(['status' => 'under_review']); // Set back to under_review to show in Approval page

            $updatedTasks = ContentTask::where('user_id', Auth::id())->whereIn('id', $ids)->get(['judul_konten', 'brand_id']);
            foreach ($updatedTasks as $task) {
                ContentBrief::where('user_id', Auth::id())
                    ->where('title', $task->judul_konten)
                    ->where('brand_id', $task->brand_id)
                    ->update(['status' => 'Under Review']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konten dikirim ke halaman Approval.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ke Approval: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Request revision: update status → need_revision
     * dan update revision_note + revision_deadline
     */
    public function requestRevision(Request $request)
    {
        $request->validate([
            'content_task_id' => 'required|exists:content_tasks,id',
            'revision_note' => 'required|string|max:500',
            'revision_deadline' => 'nullable|date|after:today'
        ]);

        DB::beginTransaction();
        try {
            ContentTask::where('user_id', Auth::id())
                ->where('id', $request->content_task_id)
                ->where('status', 'under_review')
                ->update([
                    'status' => 'need_revision',
                    'revision_note' => $request->revision_note,
                    'revision_deadline' => $request->revision_deadline,
                ]);

            $task = ContentTask::where('user_id', Auth::id())->find($request->content_task_id);
            if ($task) {
                ContentBrief::where('user_id', Auth::id())
                    ->where('title', $task->judul_konten)
                    ->where('brand_id', $task->brand_id)
                    ->update(['status' => 'Need Revision']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Revisi berhasil dikirim.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim revisi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update revision: edit revision_note dan revision_deadline
     */
    public function updateRevision(Request $request)
    {
        $request->validate([
            'content_task_id' => 'required|exists:content_tasks,id',
            'revision_note' => 'required|string|max:500',
            'revision_deadline' => 'nullable|date|after:today'
        ]);

        DB::beginTransaction();
        try {
            ContentTask::where('user_id', Auth::id())
                ->where('id', $request->content_task_id)
                ->whereIn('status', ['need_revision', 'terevisi'])
                ->update([
                    'status' => 'need_revision', // Force back to need_revision if it was terevisi
                    'revision_note' => $request->revision_note,
                    'revision_deadline' => $request->revision_deadline,
                ]);

            // Also ensure ContentBrief status is synced
            $task = ContentTask::where('user_id', Auth::id())->find($request->content_task_id);
            if ($task) {
                ContentBrief::where('user_id', Auth::id())
                    ->where('title', $task->judul_konten)
                    ->where('brand_id', $task->brand_id)
                    ->update(['status' => 'Need Revision']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Revisi berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui revisi: ' . $e->getMessage(),
            ], 500);
        }
    }
}

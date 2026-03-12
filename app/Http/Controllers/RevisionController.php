<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentTask;
use Illuminate\Support\Facades\DB;

class RevisionController extends Controller
{
    /**
     * Daftar konten dengan status under_review dan need_revision
     */
    public function index()
    {
        // Get content tasks dengan status under_review dan need_revision
        $contentTasks = ContentTask::with(['brand', 'creator', 'productions' => function($q) {
            $q->latest()->limit(1);
        }])
        ->whereIn('status', ['under_review', 'need_revision'])
        ->orderBy('id', 'asc')
        ->get();

        // Statistics dari content_tasks.status
        $stats = [
            'total_review' => ContentTask::whereIn('status', ['under_review', 'need_revision'])->count(),
            'under_review' => ContentTask::where('status', 'under_review')->count(),
            'need_revision' => ContentTask::where('status', 'need_revision')->count(),
        ];

        return view('admin.revision.index', compact('contentTasks', 'stats'));
    }

    /**
     * Send to Approval: update status → ready_for_approval
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
            ContentTask::whereIn('id', $ids)
                ->where('status', 'under_review')
                ->update(['status' => 'ready_for_approval']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konten dikirim ke Approval.',
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
            ContentTask::where('id', $request->content_task_id)
                ->where('status', 'under_review')
                ->update([
                    'status' => 'need_revision',
                    'revision_note' => $request->revision_note,
                    'revision_deadline' => $request->revision_deadline,
                ]);

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
            ContentTask::where('id', $request->content_task_id)
                ->where('status', 'need_revision')
                ->update([
                    'revision_note' => $request->revision_note,
                    'revision_deadline' => $request->revision_deadline,
                ]);

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

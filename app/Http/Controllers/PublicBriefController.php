<?php

namespace App\Http\Controllers;

use App\Models\ContentBrief;
use App\Models\Production;
use App\Models\ContentTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PublicBriefController extends Controller
{
    /**
     * Show brief details via share token (no login required)
     * SESUAI REQUIREMENT: BISA DIAKSES TANPA LOGIN, SELALU MENAMPILKAN DATA ADMIN PEMBUAT
     */
    public function showByToken($token)
    {
        // 1. Cari brief berdasarkan token
        $brief = ContentBrief::with(['user', 'tasks', 'brand'])
            ->where('token', $token)
            ->first();

        // 2. Jika tidak ada: abort(404)
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        // 3. Ambil admin pembuat (relasi user dari brief)
        $admin = $brief->user;

        // 4. Ambil production (relasi productions dari brief)
        $productions = $brief->productions()->orderBy('created_at', 'desc')->get();

        // Default tab untuk view
        $activeTab = request()->query('tab', 'brief');

        // 5. Return ke view dengan data lengkap
        return view('public.brief', compact('brief', 'admin', 'productions', 'activeTab'));
    }

    /**
     * Store production from content creator
     */
    public function storeProduction($token, Request $request)
    {
        $brief = ContentBrief::with(['tasks'])->where('token', $token)->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        // Validate request
        $validated = $request->validate([
            'task_id' => 'required|string', // Format: task_{id} atau brief_{id}
            'video_file' => 'required|file|mimes:mp4,mov,avi,mkv,m4v,wmv,flv,mpeg,mpg,mpe,3gp,3g2,ogv,ts,m2ts,asf,f4v,jpg,jpeg,png|max:500000', // 500MB max
            'caption' => 'required|string|max:2000',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Parse task_id
        $taskId = null;
        $contentBriefId = $brief->id;

        if (str_starts_with($validated['task_id'], 'task_')) {
            $taskId = str_replace('task_', '', $validated['task_id']);
            // Validate that the task belongs to this brief
            $taskExists = $brief->tasks->where('id', $taskId)->first();
            if (!$taskExists) {
                return redirect()->route('brief.public', ['token' => $token, 'tab' => 'upload'])
                    ->with('error', 'Task tidak valid untuk brief ini.');
            }
        } elseif (str_starts_with($validated['task_id'], 'brief_')) {
            $parsedBriefId = str_replace('brief_', '', $validated['task_id']);
            if ($parsedBriefId != $brief->id) {
                return redirect()->route('brief.public', ['token' => $token, 'tab' => 'upload'])
                    ->with('error', 'Brief tidak valid.');
            }
            $taskId = null; // No specific task, it's for the whole brief
        } else {
            return redirect()->route('brief.public', ['token' => $token, 'tab' => 'upload'])
                ->with('error', 'Pilihan task tidak valid.');
        }

        try {
            // Handle file upload
            $file = $request->file('video_file');
            $fileName = time() . '_' . $brief->id . '_' . $file->getClientOriginalName();
            
            // Simpan ke storage/app/public/productions (agar bisa diakses via storage link)
            $filePath = $file->storeAs('productions', $fileName, 'public');

            // Create production record
            $production = Production::create([
                'brief_id' => $brief->id,
                'task_id' => $taskId,
                'content_task_id' => null, // Not used anymore
                'judul_konten' => $brief->title,
                'versi_video' => 'v1.0',
                'durasi_final' => $this->getVideoDuration($file),
                'catatan_produksi' => $validated['caption'] . ($validated['notes'] ? "\n\nNotes: " . $validated['notes'] : ''),
                'file_video' => $filePath,
                'status' => 'pending',
                'user_id' => $brief->user_id,
            ]);

            // Update status brief
            $brief->update(['status' => 'Under Review']);

            // Sync ke ContentTask agar muncul di notifikasi Approval & Badge Admin
            $contentTask = ContentTask::where('user_id', $brief->user_id)
                ->where('judul_konten', $brief->title)
                ->where('brand_id', $brief->brand_id)
                ->first();

            if (!$contentTask) {
                $contentTask = ContentTask::create([
                    'user_id' => $brief->user_id,
                    'brand_id' => $brief->brand_id,
                    'judul_konten' => $brief->title,
                    'status' => 'under_review',
                    'creator_id' => $brief->user_id, // Default ke admin pembuat
                ]);
            } else {
                $contentTask->update(['status' => 'under_review']);
            }

            // Hubungkan production ke content_task
            $production->update(['content_task_id' => $contentTask->id]);

            Log::info('Production uploaded by creator and synced to ContentTask', [
                'brief_id' => $brief->id,
                'production_id' => $production->id,
                'content_task_id' => $contentTask->id,
            ]);

            return redirect()->route('brief.public', ['token' => $token, 'tab' => 'upload'])
                ->with('success', 'Upload berhasil! Production akan ditinjau oleh admin.');

        } catch (\Exception $e) {
            Log::error('Failed to store production', [
                'brief_id' => $brief->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('brief.public', ['token' => $token, 'tab' => 'upload'])
                ->with('error', 'Gagal mengupload: ' . $e->getMessage());
        }
    }

    /**
     * Get video duration (simplified - in real app use ffmpeg)
     */
    private function getVideoDuration($file): string
    {
        // Simplified - return file size as approximation
        $size = $file->getSize();
        $mb = round($size / 1024 / 1024, 2);
        return $mb . ' MB';
    }

    /**
     * Show production page via token
     */
    public function showProduction($token)
    {
        $brief = ContentBrief::where('token', $token)->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        $productions = Production::where('brief_id', $brief->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.production', compact('brief', 'productions'));
    }

    /**
     * Show all briefs for admin (via token)
     */
    public function showAllBriefs($token)
    {
        $brief = ContentBrief::where('token', $token)->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        $brief->load('user');

        $adminId = $brief->user_id;

        $allBriefs = ContentBrief::where('user_id', $adminId)
            ->with(['brand', 'productions'])
            ->orderBy('created_at', 'desc')
            ->get();

        $admin = $brief->user;

        return view('public.all-briefs', compact('allBriefs', 'admin'));
    }
}

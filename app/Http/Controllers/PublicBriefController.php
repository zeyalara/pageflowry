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
     * Show brief details via share token with tab navigation
     */
    public function showBrief($token, Request $request)
    {
        $brief = ContentBrief::with(['tasks' => function($q) {
                $q->whereNull('deleted_at');
            }, 'brand', 'user', 'productions'])
            ->where('share_token', $token)
            ->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        // Get active tab (default: brief)
        $activeTab = $request->query('tab', 'brief');

        // Get success/error message if exists
        $success = $request->session()->get('success');
        $error = $request->session()->get('error');

        return view('public.brief', compact('brief', 'activeTab', 'success', 'error'));
    }

    /**
     * Store production from content creator
     */
    public function storeProduction($token, Request $request)
    {
        $brief = ContentBrief::with(['tasks' => function($q) {
                $q->whereNull('deleted_at');
            }])->where('share_token', $token)->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        // Validate request
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'video_file' => 'required|file|mimes:mp4,jpg,png|max:500000', // 500MB max
            'caption' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validate that the task belongs to this brief
        $taskExists = $brief->tasks->where('id', $validated['task_id'])->first();
        if (!$taskExists) {
            return redirect()->route('brief.public', ['token' => $token, 'tab' => 'upload'])
                ->with('error', 'Task tidak valid untuk brief ini.');
        }

        try {
            // Handle file upload
            $file = $request->file('video_file');
            $fileName = time() . '_' . $brief->id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('productions', $fileName, 'public');

            // Create production record
            $production = Production::create([
                'brief_id' => $brief->id,
                'task_id' => $validated['task_id'],
                'content_task_id' => null, // Not used anymore
                'judul_konten' => $brief->title,
                'versi_video' => 'v1.0',
                'durasi_final' => $this->getVideoDuration($file),
                'catatan_produksi' => $validated['caption'] ? "Caption: " . $validated['caption'] . "\n\nNotes: " . ($validated['notes'] ?? '-') : ($validated['notes'] ?? '-'),
                'file_video' => $filePath,
                'status' => 'pending',
                'user_id' => $brief->user_id,
            ]);

            Log::info('Production uploaded by creator', [
                'brief_id' => $brief->id,
                'production_id' => $production->id,
                'file' => $filePath,
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
     * Show production page via UUID token
     */
    public function showProduction($token)
    {
        $brief = ContentBrief::where('share_token', $token)->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        $productions = Production::where('content_task_id', $brief->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.production', compact('brief', 'productions'));
    }

    /**
     * Show all briefs for admin (via UUID token)
     */
    public function showAllBriefs($token)
    {
        $brief = ContentBrief::where('share_token', $token)->first();

        if (!$brief) {
            abort(404, 'Brief tidak ditemukan');
        }

        $brief->load('user');

        $adminId = $brief->user_id;

        $allBriefs = ContentBrief::where('user_id', $adminId)
            ->with('brand')
            ->orderBy('created_at', 'desc')
            ->get();

        $admin = $brief->user;

        return view('public.all-briefs', compact('allBriefs', 'admin'));
    }
}

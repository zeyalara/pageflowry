<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentTask;
use App\Models\ContentBrief;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index()
    {
        // Get content tasks dengan status under_review, need_revision, ready_to_publish
        $contentTasks = ContentTask::with(['brand', 'creator', 'productions' => function($q) {
            $q->latest()->limit(1);
        }])
        ->where('user_id', Auth::id())
        ->whereIn('status', ['under_review', 'need_revision', 'ready_to_publish'])
        ->orderBy('id', 'asc')
        ->get();

        // Attach publish_deadline from ContentBrief
        foreach ($contentTasks as $task) {
            $brief = ContentBrief::where('user_id', Auth::id())
                ->where('title', $task->judul_konten)
                ->where('brand_id', $task->brand_id)
                ->first(['publish_deadline']);
            $task->publish_deadline = $brief ? $brief->publish_deadline : null;
        }

        // Statistics dari content_tasks.status
        $stats = [
            'total_review' => ContentTask::where('user_id', Auth::id())->whereIn('status', ['under_review', 'need_revision', 'ready_to_publish'])->count(),
            'need_revision' => ContentTask::where('user_id', Auth::id())->where('status', 'need_revision')->count(),
            'ready_to_publish' => ContentTask::where('user_id', Auth::id())->where('status', 'ready_to_publish')->count(),
        ];

        return view('admin.approval.index', compact('contentTasks', 'stats'));
    }

    /**
     * Approve single content task
     */
    public function approveSingle(Request $request)
    {
        $request->validate([
            'content_task_id' => 'required|exists:content_tasks,id'
        ]);

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $task = ContentTask::where('user_id', Auth::id())->find($request->content_task_id);
            
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data content task tidak ditemukan.'
                ], 404);
            }

            // Update ContentTask
            $task->update([
                'status' => 'ready_to_publish',
                'approved_by' => $userId,
                'approved_at' => now(),
            ]);

            // Sync ke ContentBrief
            ContentBrief::where('user_id', Auth::id())
                ->where('title', $task->judul_konten)
                ->where('brand_id', $task->brand_id)
                ->update(['status' => 'Ready to Publish']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil disetujui.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui konten: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk approve selected content tasks.
     */
    public function approveSelected(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada konten yang dipilih.',
            ], 422);
        }

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $tasks = ContentTask::where('user_id', Auth::id())
                ->whereIn('id', $ids)
                ->get();
                
            if ($tasks->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan untuk disetujui.',
                ], 404);
            }

            foreach ($tasks as $task) {
                // Update ContentTask
                $task->update([
                    'status' => 'ready_to_publish',
                    'approved_by' => $userId,
                    'approved_at' => now(),
                ]);

                // Sync ke ContentBrief
                ContentBrief::where('user_id', Auth::id())
                    ->where('title', $task->judul_konten)
                    ->where('brand_id', $task->brand_id)
                    ->update(['status' => 'Ready to Publish']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konten disetujui dan siap dipublish.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui konten: ' . $e->getMessage(),
            ], 500);
        }
    }
}

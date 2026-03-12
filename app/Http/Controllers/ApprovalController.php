<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentTask;
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
        ->whereIn('status', ['under_review', 'need_revision', 'ready_to_publish'])
        ->orderBy('id', 'asc')
        ->get();

        // Statistics dari content_tasks.status
        $stats = [
            'total_review' => ContentTask::whereIn('status', ['under_review', 'need_revision', 'ready_to_publish'])->count(),
            'need_revision' => ContentTask::where('status', 'need_revision')->count(),
            'ready_to_publish' => ContentTask::where('status', 'ready_to_publish')->count(),
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
            ContentTask::where('id', $request->content_task_id)
                ->whereIn('status', ['under_review', 'need_revision'])
                ->update([
                    'status' => 'ready_to_publish',
                    'approved_by' => $userId,
                    'approved_at' => now(),
                ]);

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
            ContentTask::whereIn('id', $ids)
                ->whereIn('status', ['under_review', 'need_revision'])
                ->update([
                    'status' => 'ready_to_publish',
                    'approved_by' => $userId,
                    'approved_at' => now(),
                ]);

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

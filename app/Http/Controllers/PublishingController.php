<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentTask;
use App\Models\ContentBrief;
use Illuminate\Support\Facades\Auth;

class PublishingController extends Controller
{
    /**
     * Daftar konten dengan status ready_to_publish
     */
    public function index()
    {
        $contentTasks = ContentTask::with(['brand', 'creator', 'productions' => fn ($q) => $q->latest()->limit(1)])
            ->where('user_id', Auth::id())
            ->where('status', 'ready_to_publish')
            ->orderByDesc('updated_at')
            ->get();

        $publishedCount = ContentTask::where('user_id', Auth::id())->where('status', 'published')->count();

        return view('admin.publishing.index', compact('contentTasks', 'publishedCount'));
    }

    /**
     * Publish: update status → published
     */
    public function publish(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada konten yang dipilih.',
            ], 422);
        }

        ContentTask::where('user_id', Auth::id())
            ->whereIn('id', $ids)
            ->where('status', 'ready_to_publish')
            ->update(['status' => 'published']);

        $updatedTasks = ContentTask::where('user_id', Auth::id())->whereIn('id', $ids)->get(['judul_konten', 'brand_id']);
        foreach ($updatedTasks as $task) {
            ContentBrief::where('user_id', Auth::id())
                ->where('title', $task->judul_konten)
                ->where('brand_id', $task->brand_id)
                ->update(['status' => 'Published']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Konten berhasil dipublish.',
        ]);
    }
}

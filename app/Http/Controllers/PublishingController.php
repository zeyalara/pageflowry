<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentTask;

class PublishingController extends Controller
{
    /**
     * Daftar konten dengan status ready_to_publish
     */
    public function index()
    {
        $contentTasks = ContentTask::with(['brand', 'creator', 'productions' => fn ($q) => $q->latest()->limit(1)])
            ->where('status', 'ready_to_publish')
            ->orderByDesc('updated_at')
            ->get();

        $publishedCount = ContentTask::where('status', 'published')->count();

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

        ContentTask::whereIn('id', $ids)
            ->where('status', 'ready_to_publish')
            ->update(['status' => 'published']);

        return response()->json([
            'success' => true,
            'message' => 'Konten berhasil dipublish.',
        ]);
    }
}

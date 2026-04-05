<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\ContentBrief;
use App\Models\ContentTask;
use App\Models\Production;

class DashboardController extends Controller
{
    public function admin()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Stats must be real and consistent with other pages (workflow uses content_tasks statuses).
        $stats = [
            'total_brands' => Brand::where('user_id', $userId)->count(),
            'total_briefs' => ContentBrief::where('user_id', $userId)->count(), // Daftar Tugas Konten source
            'total_tasks' => ContentTask::where('user_id', $userId)->count(),   // Workflow source
            'in_production' => ContentTask::where('user_id', $userId)->where('status', 'in_production')->count(),
            'under_review' => ContentTask::where('user_id', $userId)->where('status', 'under_review')->count(),
            'need_revision' => ContentTask::where('user_id', $userId)->where('status', 'need_revision')->count(),
            'ready_to_publish' => ContentTask::where('user_id', $userId)->where('status', 'ready_to_publish')->count(),
            'published' => ContentTask::where('user_id', $userId)->where('status', 'published')->count(),
        ];

        $upcomingProduction = ContentBrief::where('user_id', $userId)
            ->with('brand:id,name')
            ->orderBy('production_deadline', 'asc')
            ->take(5)
            ->get();

        $upcomingPublish = ContentBrief::where('user_id', $userId)
            ->with('brand:id,name')
            ->orderBy('publish_deadline', 'asc')
            ->take(5)
            ->get();

        $recentBriefs = ContentBrief::where('user_id', $userId)
            ->with('brand:id,name')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $recentUploads = Production::whereHas('contentTask', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('contentTask:id,judul_konten,brand_id', 'contentTask.brand:id,name')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('dashboard.admin', compact('user', 'stats', 'upcomingProduction', 'upcomingPublish', 'recentBriefs', 'recentUploads'));
    }

    public function creator()
    {
        $user = Auth::user();
        
        // Creator only sees their own data
        $stats = [
            'total_brands' => \App\Models\Brand::where('user_id', $user->id)->where('status', 'Active')->count(),
            'total_contents' => \App\Models\ContentBrief::where('user_id', $user->id)->count(),
            'in_production' => \App\Models\ContentBrief::where('user_id', $user->id)->where('status', 'In Production')->count(),
            'under_review' => \App\Models\ContentBrief::where('user_id', $user->id)->where('status', 'Under Review')->count(),
            'need_revision' => \App\Models\ContentBrief::where('user_id', $user->id)->where('status', 'Need Revision')->count(),
            'ready_to_publish' => \App\Models\ContentBrief::where('user_id', $user->id)->where('status', 'Ready to Publish')->count(),
            'published' => \App\Models\ContentBrief::where('user_id', $user->id)->where('status', 'Published')->count(),
        ];
        
        // Get recent content briefs for this creator
        $recentContent = \App\Models\ContentBrief::where('user_id', $user->id)
            ->with('brand')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard.creator', compact('user', 'stats', 'recentContent'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function creator()
    {
        $user = Auth::user();
        
        // Data dummy untuk dashboard - nanti bisa diganti dengan data dari database
        $stats = [
            'total_brands' => 5,
            'total_contents' => 23,
            'in_production' => 8,
            'under_review' => 4,
            'need_revision' => 3,
            'ready_to_publish' => 2,
            'published' => 6,
        ];

        // Data deadline terdekat (dummy data)
        $deadlines = [
            [
                'title' => 'Product Launch Video',
                'brand' => 'TechCorp',
                'deadline' => '2024-03-15',
                'status' => 'In Production'
            ],
            [
                'title' => 'Brand Story Content',
                'brand' => 'FashionHub',
                'deadline' => '2024-03-18',
                'status' => 'Under Review'
            ],
            [
                'title' => 'Social Media Campaign',
                'brand' => 'FoodieLife',
                'deadline' => '2024-03-20',
                'status' => 'Need Revision'
            ],
        ];

        // Data aktivitas terbaru (dummy data)
        $activities = [
            [
                'type' => 'brief',
                'message' => 'Brief baru diberikan untuk "Summer Campaign"',
                'time' => '2 jam yang lalu',
                'icon' => '📋'
            ],
            [
                'type' => 'upload',
                'message' => 'Upload video untuk "Product Launch" berhasil',
                'time' => '5 jam yang lalu',
                'icon' => '📤'
            ],
            [
                'type' => 'revision',
                'message' => 'Revisi diberikan untuk "Brand Story"',
                'time' => '1 hari yang lalu',
                'icon' => '🔄'
            ],
            [
                'type' => 'approved',
                'message' => 'Konten "Tech Review" diapprove',
                'time' => '2 hari yang lalu',
                'icon' => '✅'
            ],
            [
                'type' => 'published',
                'message' => 'Konten "Food Festival" dipublish',
                'time' => '3 hari yang lalu',
                'icon' => '🚀'
            ],
        ];

        return view('dashboard.creator', compact('user', 'stats', 'deadlines', 'activities'));
    }
}

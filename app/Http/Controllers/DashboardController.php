<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Access denied. Admin role required.');
        }
        
        $user = Auth::user();
        
        // Admin sees all brands data
        $stats = [
            'total_brands' => 12,
            'total_contents' => 45,
            'in_production' => 15,
            'under_review' => 8,
            'need_revision' => 6,
            'ready_to_publish' => 4,
            'published' => 12,
        ];

        // Data deadline terdekat (admin sees all)
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

        // Data aktivitas terbaru
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

        return view('dashboard.admin', compact('user', 'stats', 'deadlines', 'activities'));
    }

    public function creator()
    {
        $user = Auth::user();
        
        // Creator only sees their assigned brands data
        $stats = [
            'total_brands' => 3,
            'total_contents' => 15,
            'in_production' => 5,
            'under_review' => 3,
            'need_revision' => 2,
            'ready_to_publish' => 2,
            'published' => 3,
        ];

        // Data deadline terdekat (creator only sees their brands)
        $deadlines = [
            [
                'title' => 'Product Review Video',
                'brand' => 'MyTechBrand',
                'deadline' => '2024-03-16',
                'status' => 'In Production'
            ],
            [
                'title' => 'Brand Story Content',
                'brand' => 'FashionCreator',
                'deadline' => '2024-03-19',
                'status' => 'Under Review'
            ],
            [
                'title' => 'Social Media Campaign',
                'brand' => 'FoodieCreator',
                'deadline' => '2024-03-21',
                'status' => 'Ready to Publish'
            ],
        ];

        // Data aktivitas terbaru
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

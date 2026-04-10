<?php

namespace App\Http\Controllers;

use App\Models\ContentBrief;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PublicBriefController extends Controller
{
    /**
     * Show brief details via share token
     */
    public function showBrief($token)
    {
        $brief = ContentBrief::findByShareToken($token);
        
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan atau link sudah kadaluarsa');
        }
        
        // Load all related data based on admin who created the brief
        $brief->load(['brand', 'user', 'productions' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('public.brief', compact('brief'));
    }
    
    /**
     * Show production page via share token
     */
    public function showProduction($token)
    {
        $brief = ContentBrief::findByShareToken($token);
        
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan atau link sudah kadaluarsa');
        }
        
        // Load productions for this brief (admin's data)
        $productions = Production::where('content_task_id', $brief->id)
            ->with('contentTask.brand')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('public.production', compact('brief', 'productions'));
    }
    
    /**
     * Show all briefs for admin (via token)
     */
    public function showAllBriefs($token)
    {
        $brief = ContentBrief::findByShareToken($token);
        
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan atau link sudah kadaluarsa');
        }
        
        // Get all briefs from the same admin who created the original brief
        $adminId = $brief->user_id;
        $allBriefs = ContentBrief::where('user_id', $adminId)
            ->with('brand')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $admin = $brief->user;
        
        return view('public.all-briefs', compact('allBriefs', 'admin'));
    }
}

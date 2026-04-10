<?php

namespace App\Http\Controllers;

use App\Models\ContentBrief;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PublicBriefController extends Controller
{
    /**
     * Show brief details via UUID token
     */
    public function showBrief($token)
    {
        // Find brief by public_token (UUID)
        $brief = ContentBrief::where('public_token', $token)->first();
        
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan atau link tidak valid');
        }
        
        // Load all related data based on admin who created the brief
        $brief->load(['brand', 'user', 'productions' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('public.brief', compact('brief'));
    }
    
    /**
     * Show production page via UUID token
     */
    public function showProduction($token)
    {
        // Find brief by public_token (UUID)
        $brief = ContentBrief::where('public_token', $token)->first();
        
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan atau link tidak valid');
        }
        
        // Load productions for this brief (admin's data)
        $productions = Production::where('content_task_id', $brief->id)
            ->with('contentTask.brand')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('public.production', compact('brief', 'productions'));
    }
    
    /**
     * Show all briefs for admin (via UUID token)
     */
    public function showAllBriefs($token)
    {
        // Find brief by public_token (UUID)
        $brief = ContentBrief::where('public_token', $token)->first();
        
        if (!$brief) {
            abort(404, 'Brief tidak ditemukan atau link tidak valid');
        }
        
        // Get all briefs from same admin who created original brief
        $adminId = $brief->user_id;
        $allBriefs = ContentBrief::where('user_id', $adminId)
            ->with('brand')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $admin = $brief->user;
        
        return view('public.all-briefs', compact('allBriefs', 'admin'));
    }
}

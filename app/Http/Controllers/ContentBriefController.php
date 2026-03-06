<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentBrief;
use App\Models\Brand;
use App\Models\User;

class ContentBriefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $briefs = ContentBrief::with(['brand', 'creator'])->latest()->get();
        return view('brief.index', compact('briefs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 'Active')->get();
        $creators = User::where('role', 'creator')->get();
        return view('brief.create', compact('brands', 'creators'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'creator_id' => 'nullable|exists:users,id',
            'platform' => 'required|in:Instagram,TikTok,YouTube',
            'content_format' => 'required|string|max:255',
            'target_duration' => 'required|string|max:255',
            'production_deadline' => 'required|date',
            'publish_deadline' => 'required|date|after_or_equal:production_deadline',
            'objective' => 'required|string',
            'target_audience' => 'required|string',
            'key_message' => 'required|string',
            'hook' => 'required|string',
            'storyline' => 'required|string',
            'visual_direction' => 'required|string',
            'caption' => 'required|string',
            'cta' => 'required|string',
            'hashtags' => 'required|string',
            'target_views' => 'required|string|max:255',
            'target_engagement' => 'required|string|max:255',
        ]);

        ContentBrief::create($request->all());
        
        return redirect()->route('brief.index')
            ->with('success', 'Content brief berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brief = ContentBrief::with(['brand', 'creator'])->findOrFail($id);
        return view('brief.show', compact('brief'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brief = ContentBrief::findOrFail($id);
        $brands = Brand::where('status', 'Active')->get();
        $creators = User::where('role', 'creator')->get();
        return view('brief.edit', compact('brief', 'brands', 'creators'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brief = ContentBrief::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'creator_id' => 'nullable|exists:users,id',
            'platform' => 'required|in:Instagram,TikTok,YouTube',
            'content_format' => 'required|string|max:255',
            'target_duration' => 'required|string|max:255',
            'production_deadline' => 'required|date',
            'publish_deadline' => 'required|date|after_or_equal:production_deadline',
            'objective' => 'required|string',
            'target_audience' => 'required|string',
            'key_message' => 'required|string',
            'hook' => 'required|string',
            'storyline' => 'required|string',
            'visual_direction' => 'required|string',
            'caption' => 'required|string',
            'cta' => 'required|string',
            'hashtags' => 'required|string',
            'target_views' => 'required|string|max:255',
            'target_engagement' => 'required|string|max:255',
        ]);

        $brief->update($request->all());
        
        return redirect()->route('brief.index')
            ->with('success', 'Content brief berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brief = ContentBrief::findOrFail($id);
        $brief->delete();
        
        return redirect()->route('brief.index')
            ->with('success', 'Content brief berhasil dihapus!');
    }
}

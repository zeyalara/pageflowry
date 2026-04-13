<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Always scope to logged-in user.
        $brands = Brand::where('user_id', Auth::id())
            ->withCount([
                'contentTasks as contents_count' => function ($q) {
                    $q->where('user_id', Auth::id());
                },
                'contentTasks as published_count' => function ($q) {
                    $q->where('user_id', Auth::id())->where('status', 'published');
                },
                'contentTasks as in_progress_count' => function ($q) {
                    $q->where('user_id', Auth::id())->whereIn('status', ['in_production', 'under_review', 'need_revision', 'ready_to_publish']);
                },
            ])
            ->orderBy('name', 'asc')
            ->get();
        
        // Debug: Log the actual data from database
        Log::info('BrandController: Total brands from database: ' . $brands->count());
        Log::info('BrandController: Raw database data: ' . json_encode($brands->toArray()));
        
        // Log each brand individually for verification
        foreach($brands as $index => $brand) {
            Log::info("Brand #" . ($index + 1) . " - ID: " . $brand->id . ", Name: '" . $brand->name . "', PIC: '" . $brand->pic . "', Status: '" . $brand->status . "', Created: '" . $brand->created_at . "'");
        }
        
        // Verify no brands are missing
        $expectedCount = $brands->count();
        Log::info("BrandController: Expected to display " . $expectedCount . " brands in the view");
        
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::where('user_id', Auth::id())->findOrFail($id);
        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::where('user_id', Auth::id())->findOrFail($id);
        return view('brands.edit', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'target_market' => 'nullable|string',
            'description' => 'nullable|string',
            'tone_voice' => 'required|string',
            'status' => 'required|in:Active,Non Active',
        ], [], [
            'name.required' => 'Nama brand harus diisi',
            'pic.required' => 'PIC harus diisi',
            'contact.required' => 'Kontak harus diisi',
            'tone_voice.required' => 'Tone of voice harus diisi',
            'status.required' => 'Status harus diisi',
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'pic' => $request->pic,
            'contact' => $request->contact,
            'target_market' => $request->target_market,
            'description' => $request->description,
            'tone' => $request->tone_voice, // Map tone_voice to tone field
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil ditambahkan!',
                'brand' => $brand
            ]);
        }

        return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'target_market' => 'nullable|string',
            'description' => 'nullable|string',
            'tone_voice' => 'required|string',
            'status' => 'required|in:Active,Non Active',
        ]);

        $brand->update([
            'name' => $request->name,
            'pic' => $request->pic,
            'contact' => $request->contact,
            'target_market' => $request->target_market,
            'description' => $request->description,
            'tone' => $request->tone_voice, // Map tone_voice to tone field
            'status' => $request->status,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil diperbarui!',
                'brand' => $brand
            ]);
        }
        
        return redirect()->route('brands.index')->with('success', 'Brand berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::where('user_id', Auth::id())->findOrFail($id);
        $brand->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil dihapus!'
            ]);
        }
        
        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
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
            'target_market' => 'required|string',
            'tone' => 'required|array',
            'tone.*' => 'required|string',
            'status' => 'required|in:Active,Non Active'
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'pic' => $request->pic,
            'contact' => $request->contact,
            'target_market' => $request->target_market,
            'tone' => is_array($request->tone) ? implode(',', $request->tone) : $request->tone,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'brand' => $brand,
            'message' => 'Brand berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'target_market' => 'required|string',
            'tone' => 'required|array',
            'tone.*' => 'required|string',
            'status' => 'required|in:Active,Non Active'
        ]);

        $brand->update([
            'name' => $request->name,
            'pic' => $request->pic,
            'contact' => $request->contact,
            'target_market' => $request->target_market,
            'tone' => is_array($request->tone) ? implode(',', $request->tone) : $request->tone,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'brand' => $brand,
            'message' => 'Brand berhasil diperbarui!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brandName = $brand->name;
        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => "Brand \"{$brandName}\" berhasil dihapus!"
        ]);
    }
}

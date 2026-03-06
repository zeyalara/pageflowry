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
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
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
            'tone' => 'required|string',
            'status' => 'required|in:Active,Non Active',
        ]);

        Brand::create($request->all());
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.edit', compact('brand'));
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
            'tone' => 'required|string',
            'status' => 'required|in:Active,Non Active',
        ]);

        $brand->update($request->all());
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        
        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil dihapus!');
    }
}

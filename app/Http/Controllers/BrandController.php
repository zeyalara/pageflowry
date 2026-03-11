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
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Access denied. Admin role required.');
        }
        
        // Get ALL brands from database with no filtering - show everything
        $brands = Brand::orderBy('id', 'asc')->get();
        
        // Debug: Log the actual data from database
        \Log::info('BrandController: Total brands from database: ' . $brands->count());
        \Log::info('BrandController: Raw database data: ' . json_encode($brands->toArray()));
        
        // Log each brand individually for verification
        foreach($brands as $index => $brand) {
            \Log::info("Brand #" . ($index + 1) . " - ID: " . $brand->id . ", Name: '" . $brand->name . "', PIC: '" . $brand->pic . "', Status: '" . $brand->status . "', Created: '" . $brand->created_at . "'");
        }
        
        // Verify no brands are missing
        $expectedCount = $brands->count();
        \Log::info("BrandController: Expected to display " . $expectedCount . " brands in the view");
        
        return view('brands.index', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'pic' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'target_market' => 'required|string',
                'tone' => 'required|string',
                'status' => 'required|in:Active,Non Active',
            ]);

            // Create brand with all required fields
            $brand = Brand::create([
                'name' => $validated['name'],
                'pic' => $validated['pic'],
                'contact' => $validated['contact'],
                'target_market' => $validated['target_market'],
                'tone' => $validated['tone'],
                'status' => $validated['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Log successful creation
            \Log::info('Brand created successfully: ID ' . $brand->id . ', Name: ' . $brand->name);
            
            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil ditambahkan!',
                'brand' => $brand
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Brand validation failed: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Brand creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
        
        return response()->json([
            'success' => true,
            'message' => 'Brand berhasil diperbarui!',
            'brand' => $brand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Brand berhasil dihapus!'
        ]);
    }
}
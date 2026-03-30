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
            // Quick validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'pic' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'target_market' => 'required|string',
                'tone' => 'required|string',
                'status' => 'required|in:Active,Non Active',
            ], [], [
                'name.required' => 'Nama brand harus diisi',
                'pic.required' => 'PIC harus diisi',
                'contact.required' => 'Kontak harus diisi',
                'target_market.required' => 'Target market harus diisi',
                'tone.required' => 'Tone harus diisi',
                'status.required' => 'Status harus diisi',
            ]);

            // Fast brand creation
            $brand = Brand::create([
                'name' => $validated['name'],
                'pic' => $validated['pic'],
                'contact' => $validated['contact'],
                'target_market' => $validated['target_market'],
                'tone' => $validated['tone'],
                'status' => $validated['status'],
            ]);
            
            // Fast response
            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil ditambahkan!',
                'brand' => [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'pic' => $brand->pic,
                    'contact' => $brand->contact,
                    'target_market' => $brand->target_market,
                    'tone' => $brand->tone,
                    'status' => $brand->status,
                    'created_at' => $brand->created_at->format('Y-m-d H:i:s')
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', array_values($e->errors())[0] ?? ['Unknown validation error']),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
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
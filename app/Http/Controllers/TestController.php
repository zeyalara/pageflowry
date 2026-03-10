<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class TestController extends Controller
{
    public function testBrandStore(Request $request)
    {
        try {
            $brand = Brand::create([
                'name' => 'Test AJAX Brand',
                'pic' => 'Test AJAX PIC',
                'contact' => 'ajax@test.com',
                'target_market' => 'AJAX Market',
                'tone' => 'AJAX Tone',
                'status' => 'Active'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Brand berhasil ditambahkan!',
                'brand' => $brand
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

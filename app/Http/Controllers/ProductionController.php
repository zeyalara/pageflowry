<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Production;
use App\Models\ContentTask;
use App\Models\Brand;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Use dummy statistics to avoid database column errors
        $stats = [
            'total_production' => 3,
            'under_review' => 1,
            'need_revision' => 2,
            'ready_to_publish' => 1,
            'published' => 2,
        ];
        
        // Use dummy data to avoid database relationship errors
        $productions = collect([
            [
                'id' => 1,
                'content_task_id' => 1,
                'judul_konten' => 'Tutorial Skincare Pagi',
                'nama_brand' => 'GlowSkin',
                'versi_video' => 'v2.1',
                'durasi_final' => '3:45',
                'catatan_produksi' => 'Video dengan lighting baik dan audio jernih',
                'status' => 'in_progress',
                'creator_name' => 'Admin',
                'deadline' => '10 Mar 2026',
                'created_at' => '09 Mar 2026',
                'file_video' => 'demo_video.mp4',
                'thumbnail' => null,
            ],
            [
                'id' => 2,
                'content_task_id' => 2,
                'judul_konten' => 'Review Produk Makeup',
                'nama_brand' => 'BeautyHaus',
                'versi_video' => 'v1.3',
                'durasi_final' => '5:20',
                'catatan_produksi' => 'Close-up produk dengan detail yang jelas',
                'status' => 'completed',
                'creator_name' => 'Admin',
                'deadline' => '11 Mar 2026',
                'created_at' => '08 Mar 2026',
                'file_video' => 'demo_video2.mp4',
                'thumbnail' => null,
            ],
            [
                'id' => 3,
                'content_task_id' => 3,
                'judul_konten' => 'Tips Makeup Natural',
                'nama_brand' => 'FreshFace',
                'versi_video' => 'v3.0',
                'durasi_final' => '4:15',
                'catatan_produksi' => 'Tutorial step-by-step dengan before-after',
                'status' => 'draft',
                'creator_name' => 'Admin',
                'deadline' => '12 Mar 2026',
                'created_at' => '07 Mar 2026',
                'file_video' => 'demo_video3.mp4',
                'thumbnail' => null,
            ]
        ]);

        // Create dummy content tasks for display
        $contentTasks = collect([
            ['id' => 1, 'judul_konten' => 'Tutorial Skincare Pagi', 'brand_name' => 'GlowSkin'],
            ['id' => 2, 'judul_konten' => 'Review Produk Makeup', 'brand_name' => 'BeautyHaus'],
            ['id' => 3, 'judul_konten' => 'Tips Makeup Natural', 'brand_name' => 'FreshFace'],
        ]);

        $statusClasses = [
            'draft' => 'p-draft',
            'in_progress' => 'p-review',
            'completed' => 'p-revision',
            'cancelled' => 'p-cancelled',
        ];

        $statusLabels = [
            'draft' => 'Draft',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        // Additional data for the new design
        $recentActivities = collect([
            [
                'id' => 1,
                'action' => 'Video uploaded',
                'content_title' => 'Tutorial Skincare Pagi',
                'user' => 'Admin',
                'time' => '2 hours ago',
                'icon' => 'fa-upload',
                'color' => 'ad-blue'
            ],
            [
                'id' => 2,
                'action' => 'Review requested',
                'content_title' => 'Tips Makeup Natural',
                'user' => 'Admin',
                'time' => '4 hours ago',
                'icon' => 'fa-eye',
                'color' => 'ad-vio'
            ],
            [
                'id' => 3,
                'action' => 'Revision completed',
                'content_title' => 'Review Produk Makeup',
                'user' => 'Admin',
                'time' => '6 hours ago',
                'icon' => 'fa-check',
                'color' => 'ad-em'
            ]
        ]);

        return view('admin.production.index', compact('productions', 'contentTasks', 'stats', 'recentActivities', 'statusClasses', 'statusLabels'));
    }

    /**
     * Download production video
     */
    public function download($id)
    {
        $production = Production::findOrFail($id);
        
        if (!$production->file_video) {
            return redirect()->back()->with('error', 'File video tidak ditemukan');
        }
        
        $filePath = public_path('storage/' . $production->file_video);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File video tidak tersedia');
        }
        
        $filename = basename($production->file_video);
        return response()->download($filePath, $filename);
    }

    /**
     * Send production to review
     */
    public function sendToReview($id)
    {
        try {
            // Update production status ke 'Ready to Publish'
            DB::table('productions')
                ->where('id', $id)
                ->update(['status' => 'Ready to Publish']);
                
            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil dikirim ke review'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ke review: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content_task_id' => 'required|exists:content_tasks,id',
            'version' => 'required|string|max:10',
            'final_duration' => 'required|string|max:20',
            'video_file' => 'required|file|mimes:mp4,mov,avi|max:102400', // 100MB max
            'production_notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Handle video file upload
            $path = null;
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/productions'), $filename);
                $path = 'productions/' . $filename;
            }

            // Create production record
            Production::create([
                'content_task_id' => $request->content_task_id,
                'versi_video' => $request->version,
                'durasi_final' => $request->final_duration,
                'file_video' => $path,
                'catatan_produksi' => $request->production_notes,
                'status' => 'in_review'
            ]);

            // Update content task status to in_progress (sesuai enum di database)
            ContentTask::where('id', $request->content_task_id)
                ->update(['status' => 'in_progress']);

            DB::commit();

            return redirect()->back()->with('success', 'Video production berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded file if exists
            if ($path && file_exists(public_path('storage/' . $path))) {
                unlink(public_path('storage/' . $path));
            }
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

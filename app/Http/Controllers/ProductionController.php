<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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
        // Base query: task yang tampil di tabel (status workflow produksi)
        $workflowStatuses = ['in_production', 'under_review', 'need_revision', 'ready_to_publish', 'published'];

        $baseQuery = ContentTask::with([
                'brand',
                'creator',
                'productions' => function ($q) {
                    $q->latest()->limit(1);
                },
            ])
            ->whereIn('status', $workflowStatuses);

        // Data untuk tabel
        $contentTasks = (clone $baseQuery)
            ->orderBy('id', 'asc')
            ->get();

        // Get tasks for dropdown (status = in_production only)
        $tasks = ContentTask::where('status', 'in_production')->get();
        
        // Debug: Check if tasks exist
        // dd($tasks->toArray()); // Uncomment to debug

        // Statistik di-card diambil dari data yang sama dengan tabel (supaya angka sinkron)
        $stats = [
            'total_tasks'    => $contentTasks->count(),
            'in_production'  => $contentTasks->where('status', 'in_production')->count(),
            'under_review'   => $contentTasks->where('status', 'under_review')->count(),
            'ready_to_publish' => $contentTasks->where('status', 'ready_to_publish')->count(),
        ];

        return view('admin.production.index', compact('contentTasks', 'tasks', 'stats'));
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
        // Handle AJAX validation
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'content_task_id' => 'required|exists:content_tasks,id',
                'version' => 'required|string|max:10',
                'final_duration' => 'required|string|max:20',
                'video_file' => 'required|file|mimes:mp4,mov,avi|max:102400', // 100MB max
                'production_notes' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }
        } else {
            $request->validate([
                'content_task_id' => 'required|exists:content_tasks,id',
                'version' => 'required|string|max:10',
                'final_duration' => 'required|string|max:20',
                'video_file' => 'required|file|mimes:mp4,mov,avi|max:102400', // 100MB max
                'production_notes' => 'nullable|string|max:500'
            ]);
        }

        try {
            DB::beginTransaction();

            // Handle video file upload
            $path = null;
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                
                // Validate file
                if (!$file->isValid()) {
                    throw new \Exception('File upload tidak valid');
                }
                
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('storage/productions');
                
                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                if (!$file->move($uploadPath, $filename)) {
                    throw new \Exception('Gagal memindahkan file');
                }
                
                $path = 'productions/' . $filename;
            }

            // Create production record
            Production::create([
                'content_task_id' => $request->content_task_id,
                'versi_video' => $request->version,
                'durasi_final' => $request->final_duration,
                'file_video' => $path,
                'catatan_produksi' => $request->production_notes,
            ]);

            // Update content task status to under_review
            ContentTask::where('id', $request->content_task_id)
                ->update(['status' => 'under_review']);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video production berhasil diupload!'
                ]);
            }

            return redirect()->back()->with('success', 'Video production berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded file if exists
            if ($path && file_exists(public_path('storage/' . $path))) {
                unlink(public_path('storage/' . $path));
            }
            
            Log::error('Production upload error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
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

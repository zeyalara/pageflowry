<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\ContentBrief;
use App\Models\Production;
use App\Models\ContentTask;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;

class ProductionController extends Controller
{
    /**
     * Aturan upload video/image: selaras dengan input file accept="video/*,image/*".
     *
     * @return array<int, string|\Closure>
     */
    protected function videoFileRules(): array
    {
        return [
            'required',
            'file',
            function (string $attribute, mixed $value, \Closure $fail): void {
                if (! $value instanceof UploadedFile) {
                    return;
                }
                if (! $value->isValid()) {
                    return;
                }
                $mime = strtolower((string) $value->getMimeType());
                if ($mime === '' || $mime === 'application/octet-stream') {
                    $mime = strtolower((string) $value->getClientMimeType());
                }
                if ($mime !== '' && (str_starts_with($mime, 'video/') || str_starts_with($mime, 'image/'))) {
                    return;
                }
                $ext = strtolower((string) $value->getClientOriginalExtension());
                $allowedExts = ['mp4', 'mov', 'avi', 'webm', 'mkv', 'm4v', 'wmv', 'flv', 'mpeg', 'mpg', 'mpe', '3gp', '3g2', 'ogv', 'ts', 'm2ts', 'asf', 'f4v', 'jpg', 'jpeg', 'png'];
                if ($ext !== '' && in_array($ext, $allowedExts, true)) {
                    return;
                }
                $fail('File harus berformat video atau gambar (jpg, jpeg, png).');
            },
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get real productions data with brief and task relationships
        $productions = Production::with(['brief.brand', 'task', 'simpleTask', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Get tasks for dropdown (only for active brands AND status is 'In Production' or 'Need Revision')
        // Taking from ContentBrief (Daftar Tugas Konten)
        $tasks = ContentBrief::where('user_id', Auth::id())
            ->whereHas('brand', function($query) {
                $query->where('status', 'Active');
            })
            ->whereIn('status', ['In Production', 'Need Revision'])
            ->where('status', '!=', 'draft')
            ->orderBy('title', 'asc')
            ->get()
            ->map(function($task) {
                return (object)[
                    'id' => $task->id,
                    'judul_konten' => $task->title
                ];
            });

        // Statistik
        $stats = [
            'total_tasks'    => $productions->count(),
            'in_production'  => $productions->where('status', 'pending')->count(),
            'under_review'   => $productions->where('status', 'under_review')->count(),
            'ready_to_publish' => $productions->where('status', 'approved')->count(),
        ];

        return view('admin.production.index', compact('productions', 'tasks', 'stats'));
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
            $filePath = storage_path('app/public/' . $production->file_video);
        }
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak tersedia di storage');
        }
        
        $filename = basename($production->file_video);
        return response()->download($filePath, $filename);
    }

    /**
     * Approve production
     */
    public function approve($id)
    {
        $production = Production::where('user_id', Auth::id())->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $production->status = 'approved';
            $production->save();
            
            // Sync status to ContentBrief if brief_id exists
            if ($production->brief_id) {
                $brief = ContentBrief::findOrFail($production->brief_id);
                $brief->update(['status' => 'Under Review']);

                // Ensure a ContentTask exists for the Approval menu
                $task = ContentTask::where('user_id', Auth::id())
                    ->where('judul_konten', $brief->title)
                    ->where('brand_id', $brief->brand_id)
                    ->first();

                if (!$task) {
                    $task = ContentTask::create([
                        'user_id' => Auth::id(),
                        'brand_id' => $brief->brand_id,
                        'judul_konten' => $brief->title,
                        'status' => 'under_review',
                        'creator_id' => Auth::id(), // Default to current user
                    ]);
                } else {
                    $task->update(['status' => 'under_review']);
                }

                // Link production to content_task if not already linked
                if (!$production->content_task_id) {
                    $production->update(['content_task_id' => $task->id]);
                }
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Production telah dikirim ke menu Approval untuk direview');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses approval: ' . $e->getMessage());
        }
    }

    /**
     * Set production to revision
     */
    public function revision($id)
    {
        $production = Production::where('user_id', Auth::id())->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $production->status = 'revision';
            $production->save();
            
            // Sync status to ContentBrief if brief_id exists
            if ($production->brief_id) {
                $brief = ContentBrief::findOrFail($production->brief_id);
                $brief->update(['status' => 'Need Revision']);

                // Ensure a ContentTask exists for the Revision menu
                $task = ContentTask::where('user_id', Auth::id())
                    ->where('judul_konten', $brief->title)
                    ->where('brand_id', $brief->brand_id)
                    ->first();

                if (!$task) {
                    $task = ContentTask::create([
                        'user_id' => Auth::id(),
                        'brand_id' => $brief->brand_id,
                        'judul_konten' => $brief->title,
                        'status' => 'need_revision',
                        'creator_id' => Auth::id(),
                    ]);
                } else {
                    $task->update(['status' => 'need_revision']);
                }

                // Link production to content_task if not already linked
                if (!$production->content_task_id) {
                    $production->update(['content_task_id' => $task->id]);
                }
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Production telah dikirim ke menu Revision untuk diperbaiki');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses revisi: ' . $e->getMessage());
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
        // Handle AJAX validation
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'content_task_id' => 'required|exists:content_briefs,id',
                'version' => 'required|string|max:10',
                'final_duration' => 'required|string|max:20',
                'video_file' => $this->videoFileRules(),
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
                'content_task_id' => 'required|exists:content_briefs,id',
                'version' => 'required|string|max:10',
                'final_duration' => 'required|string|max:20',
                'video_file' => $this->videoFileRules(),
                'production_notes' => 'nullable|string|max:500'
            ]);
        }

        try {
            // Increase limits for large file uploads
            set_time_limit(0);
            ini_set('memory_limit', '512M');

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

            // Ambil data dari ContentBrief (Daftar Tugas Konten)
            $contentBrief = ContentBrief::where('user_id', Auth::id())->findOrFail($request->content_task_id);

            // Create production record
            Production::create([
                'brief_id' => $request->content_task_id, // Gunakan brief_id karena ini merujuk ke ContentBrief
                'content_task_id' => null, // Explicitly set to null to avoid FK constraint on content_tasks
                'judul_konten' => $contentBrief->title,
                'versi_video' => $request->version,
                'durasi_final' => $request->final_duration,
                'file_video' => $path,
                'catatan_produksi' => $request->production_notes,
                'user_id' => Auth::id(), // Pastikan user_id disimpan
            ]);

            // Update status di content_briefs menjadi 'Under Review'
            $contentBrief->update(['status' => 'Under Review']);

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

    /**
     * Preview production file
     */
    public function preview($id)
    {
        $production = Production::whereHas('brief', function($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);
        
        if (!$production->file_video) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }
        
        $filePath = public_path('storage/' . $production->file_video);
        
        if (!file_exists($filePath)) {
            $filePath = storage_path('app/public/' . $production->file_video);
        }
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File tidak tersedia'], 404);
        }
        
        $ext = strtolower(pathinfo($production->file_video, PATHINFO_EXTENSION));
        $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm', '3gp']);
        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
        
        return response()->json([
            'id' => $production->id,
            'title' => optional($production->brief)->title ?? 'Production',
            'file_path' => asset('storage/' . $production->file_video),
            'file_name' => basename($production->file_video),
            'is_video' => $isVideo,
            'is_image' => $isImage,
            'status' => $production->status,
            'debug_ext' => $ext,
            'debug_file' => $production->file_video,
        ]);
    }
}

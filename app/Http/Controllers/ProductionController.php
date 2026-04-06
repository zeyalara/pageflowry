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
     * Aturan upload video: selaras dengan input file accept="video/*" (semua format video di pemilih file).
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
                if ($mime !== '' && str_starts_with($mime, 'video/')) {
                    return;
                }
                $ext = strtolower((string) $value->getClientOriginalExtension());
                $videoExts = ['mp4', 'mov', 'avi', 'webm', 'mkv', 'm4v', 'wmv', 'flv', 'mpeg', 'mpg', 'mpe', '3gp', '3g2', 'ogv', 'ts', 'm2ts', 'asf', 'f4v'];
                if ($ext !== '' && in_array($ext, $videoExts, true)) {
                    return;
                }
                $fail('File harus berformat video (gunakan filter Video di dialog pilih file).');
            },
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Connect "Daftar Tugas Konten" (ContentBrief) -> dropdown in Production (ContentTask).
        // We only create missing ContentTask rows; we do NOT update existing ones so workflow statuses
        // (under_review, need_revision, etc.) remain controlled by production/revision/approval actions.
        $contentBriefs = ContentBrief::select(['id', 'title', 'description', 'brand_id', 'creator_id', 'user_id', 'production_deadline', 'status'])
            ->where('user_id', Auth::id())
            ->get();

        foreach ($contentBriefs as $brief) {
            $existing = ContentTask::where('judul_konten', $brief->title)
                ->where('brand_id', $brief->brand_id)
                ->first();

            if ($existing) {
                continue;
            }

            $statusMap = [
                'In Production' => 'in_production',
                'Under Review' => 'under_review',
                'Need Revision' => 'need_revision',
                'Ready to Publish' => 'ready_to_publish',
                'Published' => 'published',
            ];

            $mappedStatus = $statusMap[$brief->status] ?? 'draft';
            $deadline = $brief->production_deadline ? Carbon::parse($brief->production_deadline)->startOfDay() : null;

            ContentTask::create([
                'user_id' => $brief->user_id ?? $brief->creator_id,
                'judul_konten' => $brief->title,
                'deskripsi' => $brief->description,
                'brand_id' => $brief->brand_id,
                'creator_id' => $brief->creator_id,
                'status' => $mappedStatus,
                'deadline' => $deadline,
            ]);
        }

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
        
        // Scope to current user
        $baseQuery->where('user_id', Auth::id());

        // Data untuk tabel
        $contentTasks = (clone $baseQuery)
            ->orderBy('id', 'asc')
            ->get();

        // Get tasks for dropdown.
        // User expects "Pilih Content Task" to show all content tasks from
        // the "Daftar Tugas Konten" menu, regardless of status.
        $tasks = ContentTask::where('user_id', Auth::id())->orderBy('id', 'asc')->get();
        
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
                'content_task_id' => 'required|exists:content_tasks,id',
                'version' => 'required|string|max:10',
                'final_duration' => 'required|string|max:20',
                'video_file' => $this->videoFileRules(),
                'production_notes' => 'nullable|string|max:500'
            ]);
        }

        try {
            // Video besar butuh waktu baca/move file; hindari timeout default PHP di hosting.
            set_time_limit(0);

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

            // `productions.judul_konten` adalah field wajib (NOT NULL)
            // Ambil dari ContentTask yang dipilih.
            $contentTask = ContentTask::where('user_id', Auth::id())->findOrFail($request->content_task_id);

            // Create production record
            Production::create([
                'content_task_id' => $request->content_task_id,
                'judul_konten' => $contentTask->judul_konten,
                'versi_video' => $request->version,
                'durasi_final' => $request->final_duration,
                'file_video' => $path,
                'catatan_produksi' => $request->production_notes,
            ]);

            // Update content task status to under_review
            ContentTask::where('user_id', Auth::id())
                ->where('id', $request->content_task_id)
                ->update(['status' => 'under_review']);

            // Keep status in "Daftar Tugas Konten" (content_briefs) in sync.
            ContentBrief::where('user_id', Auth::id())
                ->where('title', $contentTask->judul_konten)
                ->where('brand_id', $contentTask->brand_id)
                ->update(['status' => 'Under Review']);

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

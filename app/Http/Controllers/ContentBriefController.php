<?php

namespace App\Http\Controllers;

use App\Models\ContentBrief;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContentBriefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get only ACTIVE brands for dropdown and filter
        $brands = Brand::where('status', 'Active')->orderBy('name', 'asc')->get();
        
        // Get ALL content briefs with brand relationship
        $contentBriefs = ContentBrief::with('brand')->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics from database
        $stats = [
            'total' => $contentBriefs->count(),
            'in_production' => $contentBriefs->where('status', 'In Production')->count(),
            'under_review' => $contentBriefs->where('status', 'Under Review')->count(),
            'need_revision' => $contentBriefs->where('status', 'Need Revision')->count(),
            'published' => $contentBriefs->where('status', 'Published')->count(),
        ];
        
        return view('brief.index', compact('brands', 'contentBriefs', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get only ACTIVE brands for dropdown
        $brands = Brand::where('status', 'Active')->orderBy('name', 'asc')->get();
        
        return view('brief.create', compact('brands'));
    }

    /**
     * Search and filter content briefs via AJAX.
     */
    public function search(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $status = $request->input('status', '');
            $platform = $request->input('platform', '');
            $brand = $request->input('brand', '');
            
            // DEBUG: Log input parameters
            Log::info('ContentBrief Search Request:', [
                'search' => $search,
                'status' => $status,
                'platform' => $platform,
                'brand' => $brand
            ]);
            
            // Start query with relationship - NO USER FILTER for now
            $query = ContentBrief::with('brand');
            
            // DEBUG: Log initial query
            Log::info('Initial query before filters', [
                'has_search' => !empty($search),
                'has_status' => !empty($status),
                'has_platform' => !empty($platform),
                'has_brand' => !empty($brand)
            ]);
            
            // Apply search filter (judul konten dan nama brand)
            if (!empty($search)) {
                Log::info('Attempting search filter', ['search_term' => $search]);
                
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhereHas('brand', function($brandQuery) use ($search) {
                          $brandQuery->where('name', 'LIKE', '%' . $search . '%');
                      });
                });
                
                Log::info('Search filter applied successfully', ['search' => $search]);
            } else {
                Log::info('Search filter not applied (empty search term)');
            }
            
            // Apply status filter
            if (!empty($status)) {
                $query->where('status', $status);
                Log::info('Applied status filter:', ['status' => $status]);
            } else {
                Log::info('Status filter not applied (empty)');
            }
            
            // Apply platform filter
            if (!empty($platform)) {
                $query->where('platform', $platform);
                Log::info('Applied platform filter:', ['platform' => $platform]);
            } else {
                Log::info('Platform filter not applied (empty)');
            }
            
            // Apply brand filter
            if (!empty($brand)) {
                $query->where('brand_id', $brand);
                Log::info('Applied brand filter:', ['brand' => $brand]);
            } else {
                Log::info('Brand filter not applied (empty)');
            }
            
            // Get filtered results
            $contentBriefs = $query->orderBy('created_at', 'desc')->get();
            
            // DEBUG: Log query results
            Log::info('Query results:', [
                'total_count' => $contentBriefs->count(),
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);
            
            // Calculate statistics for filtered results
            $stats = [
                'total' => $contentBriefs->count(),
                'in_production' => $contentBriefs->where('status', 'In Production')->count(),
                'under_review' => $contentBriefs->where('status', 'Under Review')->count(),
                'need_revision' => $contentBriefs->where('status', 'Need Revision')->count(),
                'published' => $contentBriefs->where('status', 'Published')->count(),
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil difilter',
                'data' => $contentBriefs,
                'stats' => $stats,
                'filters' => [
                    'search' => $search,
                    'status' => $status,
                    'platform' => $platform,
                    'brand' => $brand,
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('ContentBrief Search Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memfilter data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate required fields
            $validated = $request->validate([
                // Informasi Dasar - Step 2
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'brand_id' => 'required|exists:brands,id',
                'platform' => 'required|string',
                'content_format' => 'required|string',
                'target_duration' => 'required|string',
                'production_deadline' => 'required|date',
                'publish_deadline' => 'required|date|after_or_equal:production_deadline',
                
                // Strategi Konten - Step 3
                'objective' => 'required|string',
                'target_audience' => 'required|string',
                'key_message' => 'required|string',
                
                // Brief Kreatif - Step 4
                'hook' => 'required|string',
                'storyline' => 'required|string',
                'visual_direction' => 'required|string',
                
                // Konten & Publishing - Step 5
                'caption' => 'required|string',
                'cta' => 'required|string',
                'hashtags' => 'required|string',
                
                // Target KPI - Step 6
                'target_views' => 'required|string',
                'target_engagement' => 'required|string',
                
                // Assign & Summary - Step 7
                'creator_email' => 'nullable|email',
            ], [
                'title.required' => 'Judul konten wajib diisi.',
                'brand_id.required' => 'Brand wajib dipilih.',
                'brand_id.exists' => 'Brand yang dipilih tidak valid.',
                'platform.required' => 'Platform wajib dipilih.',
                'content_format.required' => 'Format konten wajib dipilih.',
                'target_duration.required' => 'Durasi target wajib diisi.',
                'production_deadline.required' => 'Deadline produksi wajib diisi.',
                'publish_deadline.required' => 'Deadline publish wajib diisi.',
                'objective.required' => 'Objective wajib dipilih.',
                'target_audience.required' => 'Target audience wajib diisi.',
                'key_message.required' => 'Key message wajib diisi.',
                'hook.required' => 'Hook wajib diisi.',
                'storyline.required' => 'Storyline wajib diisi.',
                'visual_direction.required' => 'Visual direction wajib diisi.',
                'caption.required' => 'Caption wajib diisi.',
                'cta.required' => 'CTA wajib diisi.',
                'hashtags.required' => 'Hashtag wajib diisi.',
                'target_views.required' => 'Target views wajib diisi.',
                'target_engagement.required' => 'Target engagement wajib diisi.',
                'creator_email.email' => 'Email creator tidak valid.',
            ]);

            // Create new content brief with proper user_id
            $contentBrief = ContentBrief::create([
                // Informasi Dasar - Step 2
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'brand_id' => $validated['brand_id'], // Foreign key to brands table
                'platform' => $validated['platform'],
                'content_format' => $validated['content_format'],
                'target_duration' => $validated['target_duration'],
                'production_deadline' => $validated['production_deadline'],
                'publish_deadline' => $validated['publish_deadline'],
                
                // Strategi Konten - Step 3
                'objective' => $validated['objective'],
                'target_audience' => $validated['target_audience'],
                'key_message' => $validated['key_message'],
                
                // Brief Kreatif - Step 4
                'hook' => $validated['hook'],
                'storyline' => $validated['storyline'],
                'visual_direction' => $validated['visual_direction'],
                
                // Konten & Publishing - Step 5
                'caption' => $validated['caption'],
                'cta' => $validated['cta'],
                'hashtags' => $validated['hashtags'],
                
                // Target KPI - Step 6
                'target_views' => $validated['target_views'],
                'target_engagement' => $validated['target_engagement'],
                
                // Assign & Summary - Step 7
                'creator_email' => $validated['creator_email'] ?? null,
                
                // System Fields - WAJIB: user_id harus sesuai user login
                'creator_id' => auth()->check() ? auth()->user()->id : null, // Current user ID or null
                'status' => 'In Production', // Default status
            ]);

            // Send email to creator if email is provided
            $emailSent = false;
            $emailStatus = '';
            $creatorEmail = '';
            
            if (!empty($validated['creator_email'])) {
                $creatorEmail = $validated['creator_email'];
                
                Log::info('Attempting to send email to creator', [
                    'content_brief_id' => $contentBrief->id,
                    'creator_email' => $creatorEmail,
                    'mail_mailer' => config('mail.default'),
                    'mail_host' => config('mail.mailers.' . config('mail.default') . '.host')
                ]);
                
                try {
                    $this->sendCreatorNotificationEmail($contentBrief, $creatorEmail);
                    $emailSent = true;
                    $emailStatus = 'Email berhasil terkirim ke ' . $creatorEmail;
                    
                    Log::info('Creator notification email sent successfully', [
                        'content_brief_id' => $contentBrief->id,
                        'creator_email' => $creatorEmail
                    ]);
                } catch (\Exception $e) {
                    $emailStatus = 'Gagal mengirim email ke ' . $creatorEmail . ': ' . $e->getMessage();
                    
                    Log::error('Failed to send creator notification email', [
                        'content_brief_id' => $contentBrief->id,
                        'creator_email' => $creatorEmail,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                $emailStatus = 'Email tidak ditemukan (tidak ada email creator)';
                Log::info('No creator email provided, skipping email notification');
            }

            // Return success response with data
            $successMessage = $emailSent 
                ? 'Data berhasil disimpan. Email notifikasi telah dikirim ke creator.' 
                : 'Data berhasil disimpan. Tugas ditandai sebagai dikerjakan admin.';
                
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'email_sent' => $emailSent,
                'creator_email' => $creatorEmail,
                'email_status' => $emailStatus,
                'data' => [
                    'id' => $contentBrief->id,
                    'title' => $contentBrief->title,
                    'brand' => $contentBrief->brand->name,
                    'platform' => $contentBrief->platform,
                    'format' => $contentBrief->content_format,
                    'status' => $contentBrief->status,
                    'created_at' => $contentBrief->created_at->format('Y-m-d H:i:s'),
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send notification email to content creator
     */
    public function sendCreatorNotificationEmail($contentBrief, $creatorEmail)
    {
        try {
            // Generate unique link for the brief (accessible without login)
            $briefLink = url('/content-briefs/' . $contentBrief->id . '/view?token=' . md5($contentBrief->id . $contentBrief->created_at));
            
            // Prepare email data with null checks
            $emailData = [
                'title' => $contentBrief->title ?? 'Tidak ada judul',
                'brand' => isset($contentBrief->brand) ? $contentBrief->brand->name : 'Tidak ada brand',
                'platform' => $contentBrief->platform ?? 'Tidak ada platform',
                'deadline' => $contentBrief->production_deadline ? \Carbon\Carbon::parse($contentBrief->production_deadline)->format('d F Y') : 'Tidak ditentukan',
                'description' => $contentBrief->description ?? 'Tidak ada deskripsi',
                'objective' => $contentBrief->objective ?? 'Tidak ada objective',
                'briefLink' => $briefLink,
                'creatorEmail' => $creatorEmail
            ];
            
            // Send email
            Mail::to($creatorEmail)
                ->send(new \App\Mail\CreatorNotification($emailData));
                
            return true;
        } catch (\Exception $e) {
            Log::error('Error in sendCreatorNotificationEmail: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Public view for creators to access brief without login
     */
    public function publicView(string $id, Request $request)
    {
        try {
            // Get content brief with brand relationship
            $contentBrief = ContentBrief::with('brand')->findOrFail($id);
            
            // Verify token for security
            $expectedToken = md5($contentBrief->id . $contentBrief->created_at);
            $providedToken = $request->get('token');
            
            if ($providedToken !== $expectedToken) {
                abort(403, 'Akses tidak sah. Token tidak valid.');
            }
            
            // Return view for creator
            return view('brief.public-view', compact('contentBrief'));
            
        } catch (\Exception $e) {
            Log::error('Error accessing public brief view', [
                'brief_id' => $id,
                'error' => $e->getMessage()
            ]);
            abort(404, 'Brief tidak ditemukan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get only ACTIVE brands for dropdown and filter
        $brands = Brand::where('status', 'Active')->orderBy('name', 'asc')->get();
        
        // Get specific content brief with brand relationship
        $contentBrief = ContentBrief::with('brand')->findOrFail($id);
        
        return view('brief.show', compact('id', 'brands', 'contentBrief'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get only ACTIVE brands for dropdown
        $brands = Brand::where('status', 'Active')->orderBy('name', 'asc')->get();
        
        // Get specific content brief for editing
        $contentBrief = ContentBrief::findOrFail($id);
        
        return view('brief.edit', compact('id', 'brands', 'contentBrief'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $contentBrief = ContentBrief::findOrFail($id);
            
            // Validate required fields
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'brand_id' => 'required|exists:brands,id',
                'platform' => 'required|string',
                'content_format' => 'required|string',
                'target_duration' => 'required|string',
                'production_deadline' => 'required|date',
                'publish_deadline' => 'required|date|after_or_equal:production_deadline',
                'objective' => 'required|string',
                'target_audience' => 'required|string',
                'key_message' => 'required|string',
                'hook' => 'nullable|string',
                'storyline' => 'nullable|string',
                'visual_direction' => 'nullable|string',
                'caption' => 'nullable|string',
                'cta' => 'nullable|string',
                'hashtags' => 'nullable|string',
                'target_views' => 'nullable|string',
                'target_engagement' => 'nullable|string',
                'creator' => 'nullable|string',
            ]);

            // Update content brief
            $contentBrief->update([
                'title' => $validated['title'],
                'brand_id' => $validated['brand_id'],
                'platform' => $validated['platform'],
                'content_format' => $validated['content_format'],
                'target_duration' => $validated['target_duration'],
                'production_deadline' => $validated['production_deadline'],
                'publish_deadline' => $validated['publish_deadline'],
                'objective' => $validated['objective'],
                'target_audience' => $validated['target_audience'],
                'key_message' => $validated['key_message'],
                'hook' => $validated['hook'] ?? null,
                'storyline' => $validated['storyline'] ?? null,
                'visual_direction' => $validated['visual_direction'] ?? null,
                'caption' => $validated['caption'] ?? null,
                'cta' => $validated['cta'] ?? null,
                'hashtags' => $validated['hashtags'] ?? null,
                'target_views' => $validated['target_views'] ?? null,
                'target_engagement' => $validated['target_engagement'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => [
                    'id' => $contentBrief->id,
                    'title' => $contentBrief->title,
                    'brand' => $contentBrief->brand->name,
                    'platform' => $contentBrief->platform,
                    'format' => $contentBrief->content_format,
                    'status' => $contentBrief->status,
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contentBrief = ContentBrief::findOrFail($id);
            $title = $contentBrief->title;
            $contentBrief->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Brief \"{$title}\" berhasil dihapus."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ContentBrief;
use App\Models\Brand;
use App\Models\Task;
use App\Notifications\DeadlineTaskNotification;
use Carbon\Carbon;
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
        // Check and send deadline notifications (disabled until notifications table is created)
        // $this->checkDeadlineNotifications();
        
        // Get only ACTIVE brands for dropdown and filter
        $brands = Brand::where('user_id', auth()->id())
            ->where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();
        
        // Get ONLY content briefs for logged-in user with brand and tasks relationship
        $contentBriefs = ContentBrief::where('user_id', auth()->id())
            ->with(['brand', 'tasks'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics from user's data only
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
     * Check and send deadline notifications
     */
    private function checkDeadlineNotifications()
    {
        $today = Carbon::today();
        $twoDaysFromNow = (clone $today)->addDays(2)->endOfDay();

        // Get tasks with deadlines in the next 2 days or overdue
        $tasks = ContentBrief::whereNotNull('production_deadline')
            ->where(function ($query) use ($today, $twoDaysFromNow) {
                $query->where('production_deadline', '<=', $twoDaysFromNow);
            })
            ->with('brand', 'user')
            ->get();

        foreach ($tasks as $task) {
            $daysLeft = $today->diffInDays($task->production_deadline, false);
            
            if ($task->production_deadline->isPast()) {
                // Overdue deadline
                $task->user->notify(new DeadlineTaskNotification($task, 'overdue', null));
                
                // Notify all admin users
                $this->notifyAdmins(new DeadlineTaskNotification($task, 'overdue', null));
            } elseif ($daysLeft <= 2) {
                // Approaching deadline (2 days or less)
                $task->user->notify(new DeadlineTaskNotification($task, 'approaching', $daysLeft));
                
                // Notify all admin users
                $this->notifyAdmins(new DeadlineTaskNotification($task, 'approaching', $daysLeft));
            }
        }
    }

    /**
     * Notify all admin users
     */
    private function notifyAdmins($notification)
    {
        $adminUsers = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->notify($notification);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get only ACTIVE brands for dropdown
        $brands = Brand::where('user_id', auth()->id())
            ->where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();
        
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
            
            // Start query with relationship - ALWAYS FILTER BY USER
            $query = ContentBrief::with('brand')->where('user_id', auth()->id());
            
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
            if ($request->has('creator_email')) {
                $raw = $request->input('creator_email');
                $request->merge([
                    'creator_email' => (is_string($raw) && trim($raw) !== '') ? trim($raw) : null,
                ]);
            }

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
                'user_id' => auth()->id(),
                // Informasi Dasar - Step 2
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                // Ensure selected brand belongs to logged-in user
                'brand_id' => Brand::where('user_id', auth()->id())->findOrFail($validated['brand_id'])->id,
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
                'creator_id' => auth()->id(),
                'status' => 'In Production', // Default status
            ]);

            // Token generated automatically in ContentBrief::booted()
            $token = $contentBrief->token;

            $emailSent = false;
            $emailStatus = '';
            $creatorEmail = '';

            if (! empty($validated['creator_email'])) {
                $creatorEmail = $validated['creator_email'];
                $notify = $this->trySendCreatorNotification($contentBrief, $creatorEmail);
                $emailSent = $notify['sent'];
                $emailStatus = $notify['status'];
            } else {
                $emailStatus = 'Email creator tidak diisi - notifikasi tidak dikirim.';
                Log::info('No creator email provided, skipping email notification');
            }

            // Generate share links using new token-based routes - SESUAI REQUIREMENT
            $briefUrl = route('brief.public', $token);
            $productionUrl = route('public.production', $token);
            $allBriefsUrl = route('public.all-briefs', $token);

            $successMessage = "Brief \"{$contentBrief->title}\" berhasil dibuat!";
            
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'email_sent' => $emailSent,
                'creator_email' => $creatorEmail,
                'email_status' => $emailStatus,
                'share_token' => $token,
                'share_links' => [
                    'brief' => $briefUrl,
                    'production' => $productionUrl,
                    'all_briefs' => $allBriefsUrl,
                ],
                'mail_config_hint' => config('mail.default') === 'log'
                    ? 'Untuk email masuk inbox: set MAIL_MAILER=smtp dan konfigurasi MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_FROM_ADDRESS di file .env lalu php artisan config:clear.'
                    : null,
                'data' => [
                    'id' => $contentBrief->id,
                    'title' => $contentBrief->title,
                    'description' => $contentBrief->description,
                    'brand_id' => $contentBrief->brand_id,
                    'brand_name' => $contentBrief->brand->name ?? '-',
                    'platform' => $contentBrief->platform,
                    'content_format' => $contentBrief->content_format,
                    'target_duration' => $contentBrief->target_duration,
                    'production_deadline' => $contentBrief->production_deadline ? $contentBrief->production_deadline->format('Y-m-d') : null,
                    'publish_deadline' => $contentBrief->publish_deadline ? $contentBrief->publish_deadline->format('Y-m-d') : null,
                    'objective' => $contentBrief->objective,
                    'target_audience' => $contentBrief->target_audience,
                    'key_message' => $contentBrief->key_message,
                    'hook' => $contentBrief->hook,
                    'storyline' => $contentBrief->storyline,
                    'visual_direction' => $contentBrief->visual_direction,
                    'caption' => $contentBrief->caption,
                    'cta' => $contentBrief->cta,
                    'hashtags' => $contentBrief->hashtags,
                    'target_views' => (int)$contentBrief->target_views,
                    'target_engagement' => (float)$contentBrief->target_engagement,
                    'creator_email' => $contentBrief->creator_email,
                    'status' => $contentBrief->status,
                    'token' => $contentBrief->token,
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
     * Kirim email notifikasi ke creator; dipanggil otomatis saat simpan brief (tanpa aksi tambahan).
     *
     * @return array{sent: bool, status: string}
     */
    protected function trySendCreatorNotification(ContentBrief $contentBrief, string $creatorEmail): array
    {
        $contentBrief->loadMissing('brand');

        Log::info('Attempting to send email to creator', [
            'content_brief_id' => $contentBrief->id,
            'creator_email' => $creatorEmail,
            'mail_mailer' => config('mail.default'),
            'mail_host' => config('mail.mailers.'.config('mail.default').'.host'),
        ]);

        if (config('mail.default') === 'log') {
            Log::warning('MAIL_MAILER=log: email tidak dikirim ke inbox, hanya ke file log. Set MAIL_MAILER=smtp dan MAIL_* di .env.');
        }

        try {
            $this->sendCreatorNotificationEmail($contentBrief, $creatorEmail);

            Log::info('Creator notification email sent successfully', [
                'content_brief_id' => $contentBrief->id,
                'creator_email' => $creatorEmail,
            ]);

            return [
                'sent' => true,
                'status' => 'Email otomatis terkirim ke '.$creatorEmail,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to send creator notification email', [
                'content_brief_id' => $contentBrief->id,
                'creator_email' => $creatorEmail,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'sent' => false,
                'status' => 'Gagal mengirim email ke '.$creatorEmail.': '.$e->getMessage(),
            ];
        }
    }

    /**
     * Send notification email to content creator
     */
    public function sendCreatorNotificationEmail($contentBrief, $creatorEmail)
    {
        try {
            $contentBrief->loadMissing('brand');

            $briefLink = $contentBrief->publicViewUrl();

            $emailData = [
                'title' => $contentBrief->title ?? 'Tidak ada judul',
                'brand' => $contentBrief->brand->name ?? 'Tidak ada brand',
                'platform' => $contentBrief->platform ?? 'Tidak ada platform',
                'deadline' => $contentBrief->production_deadline
                    ? $contentBrief->production_deadline->format('d M Y')
                    : 'Tidak ditentukan',
                'description' => $contentBrief->description ?? 'Tidak ada deskripsi',
                'objective' => $contentBrief->objective ?? 'Tidak ada objective',
                'briefLink' => $briefLink,
                'creatorEmail' => $creatorEmail,
                'reply_to' => auth()->user()->email ?? config('mail.from.address'),
            ];

            Mail::to($creatorEmail)
                ->send(new \App\Mail\CreatorNotification($emailData));

            return true;
        } catch (\Exception $e) {
            Log::error('Error in sendCreatorNotificationEmail: '.$e->getMessage());

            throw $e;
        }
    }

    /**
     * Public view for creators to access brief without login
     */
    public function publicView(string $id, Request $request)
    {
        try {
            // Get content brief with brand relationship using find() instead of findOrFail()
            $contentBrief = ContentBrief::with('brand')->find($id);
            
            // Check if brief exists
            if (!$contentBrief) {
                Log::warning('Brief not found in public view', [
                    'brief_id' => $id,
                    'ip' => $request->ip()
                ]);
                abort(404, 'Brief tidak ditemukan dalam database.');
            }
            
            $providedToken = $request->query('share_token');
            
            // Check if token is provided
            if (!$providedToken) {
                Log::warning('No token provided for public brief view', [
                    'brief_id' => $id,
                    'ip' => $request->ip()
                ]);
                abort(403, 'Token diperlukan untuk mengakses brief ini.');
            }

            // Validate token
            if (! ContentBrief::publicViewTokenMatches($contentBrief, $providedToken)) {
                Log::warning('Invalid token provided for public brief view', [
                    'brief_id' => $id,
                    'provided_token' => $providedToken,
                    'expected_token' => $contentBrief->publicAccessToken(),
                    'ip' => $request->ip()
                ]);
                abort(403, 'Akses tidak sah. Token tidak valid atau telah kadaluarsa.');
            }
            
            // Return view for creator
            return view('brief.public-view', compact('contentBrief'));
            
        } catch (\Exception $e) {
            Log::error('Error accessing public brief view', [
                'brief_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Terjadi kesalahan saat memuat brief. Silakan coba lagi nanti.');
        }
    }

    /**
     * Show brief by public token (no authentication required)
     * Redirect to PublicBriefController
     */
    public function showByToken($token)
    {
        return redirect()->route('brief.public', ['token' => $token]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get only ACTIVE brands for dropdown and filter
        $brands = Brand::where('user_id', auth()->id())
            ->where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();
        
        // Get specific content brief with brand relationship
        $contentBrief = ContentBrief::with('brand')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('brief.show', compact('id', 'brands', 'contentBrief'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get only ACTIVE brands for dropdown
        $brands = Brand::where('user_id', auth()->id())
            ->where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();
        
        // Get specific content brief for editing
        $contentBrief = ContentBrief::where('user_id', auth()->id())->findOrFail($id);
        
        return view('brief.edit', compact('id', 'brands', 'contentBrief'));
    }

    /**
     * Update the specified resource in storage.
     * Wizard mengirim payload lengkap; email creator dikirim otomatis saat simpan jika diisi / diubah.
     */
    public function update(Request $request, string $id)
    {
        try {
            if ($request->has('creator_email')) {
                $raw = $request->input('creator_email');
                $request->merge([
                    'creator_email' => (is_string($raw) && trim($raw) !== '') ? trim($raw) : null,
                ]);
            }

            $contentBrief = ContentBrief::where('user_id', auth()->id())->findOrFail($id);
            $previousCreatorEmail = $contentBrief->creator_email ? trim((string) $contentBrief->creator_email) : null;

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'brand_id' => 'required|exists:brands,id',
                'platform' => 'required|string',
                'content_format' => 'required|string',
                'target_duration' => 'required|string',
                'production_deadline' => 'required|date',
                'publish_deadline' => 'required|date|after_or_equal:production_deadline',
                'objective' => 'required|string',
                'target_audience' => 'required|string',
                'key_message' => 'required|string',
                'hook' => 'required|string',
                'storyline' => 'required|string',
                'visual_direction' => 'required|string',
                'caption' => 'required|string',
                'cta' => 'required|string',
                'hashtags' => 'required|string',
                'target_views' => 'required|string',
                'target_engagement' => 'required|string',
                'creator_email' => 'nullable|email',
            ], [
                'title.required' => 'Judul konten wajib diisi.',
                'brand_id.required' => 'Brand wajib dipilih.',
                'creator_email.email' => 'Email creator tidak valid.',
            ]);

            $contentBrief->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'brand_id' => Brand::where('user_id', auth()->id())->findOrFail($validated['brand_id'])->id,
                'platform' => $validated['platform'],
                'content_format' => $validated['content_format'],
                'target_duration' => $validated['target_duration'],
                'production_deadline' => $validated['production_deadline'],
                'publish_deadline' => $validated['publish_deadline'],
                'objective' => $validated['objective'],
                'target_audience' => $validated['target_audience'],
                'key_message' => $validated['key_message'],
                'hook' => $validated['hook'],
                'storyline' => $validated['storyline'],
                'visual_direction' => $validated['visual_direction'],
                'caption' => $validated['caption'],
                'cta' => $validated['cta'],
                'hashtags' => $validated['hashtags'],
                'target_views' => $validated['target_views'],
                'target_engagement' => $validated['target_engagement'],
                'creator_email' => $validated['creator_email'] ?? null,
            ]);

            $contentBrief->refresh();
            $contentBrief->loadMissing('brand');

            $newCreatorEmail = isset($validated['creator_email']) && $validated['creator_email']
                ? trim($validated['creator_email'])
                : null;

            $emailSent = false;
            $emailStatus = '';
            $creatorEmailOut = '';

            $shouldSendEmail = $newCreatorEmail !== null
                && ($previousCreatorEmail === null || $previousCreatorEmail !== $newCreatorEmail);

            if ($shouldSendEmail) {
                $creatorEmailOut = $newCreatorEmail;
                $notify = $this->trySendCreatorNotification($contentBrief, $creatorEmailOut);
                $emailSent = $notify['sent'];
                $emailStatus = $notify['status'];
            } elseif ($newCreatorEmail === null) {
                $emailStatus = 'Email creator kosong — notifikasi tidak dikirim.';
            } else {
                $creatorEmailOut = $newCreatorEmail;
                $emailStatus = 'Email creator sama seperti sebelumnya — tidak dikirim ulang.';
            }

            $successMessage = $emailSent
                ? 'Perubahan disimpan. Email ke creator sudah dikirim otomatis.'
                : 'Data berhasil diperbarui.';

            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'email_sent' => $emailSent,
                'creator_email' => $creatorEmailOut,
                'email_status' => $emailStatus,
                'mail_config_hint' => config('mail.default') === 'log'
                    ? 'Untuk email masuk inbox: set MAIL_MAILER=smtp dan konfigurasi MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_FROM_ADDRESS di file .env lalu php artisan config:clear.'
                    : null,
                'data' => [
                    'id' => $contentBrief->id,
                    'title' => $contentBrief->title,
                    'description' => $contentBrief->description,
                    'brand_id' => $contentBrief->brand_id,
                    'brand_name' => $contentBrief->brand->name ?? '-',
                    'platform' => $contentBrief->platform,
                    'content_format' => $contentBrief->content_format,
                    'target_duration' => $contentBrief->target_duration,
                    'production_deadline' => $contentBrief->production_deadline ? $contentBrief->production_deadline->format('Y-m-d') : null,
                    'publish_deadline' => $contentBrief->publish_deadline ? $contentBrief->publish_deadline->format('Y-m-d') : null,
                    'objective' => $contentBrief->objective,
                    'target_audience' => $contentBrief->target_audience,
                    'key_message' => $contentBrief->key_message,
                    'hook' => $contentBrief->hook,
                    'storyline' => $contentBrief->storyline,
                    'visual_direction' => $contentBrief->visual_direction,
                    'caption' => $contentBrief->caption,
                    'cta' => $contentBrief->cta,
                    'hashtags' => $contentBrief->hashtags,
                    'target_views' => (int)$contentBrief->target_views,
                    'target_engagement' => (float)$contentBrief->target_engagement,
                    'creator_email' => $contentBrief->creator_email,
                    'status' => $contentBrief->status,
                    'token' => $contentBrief->token,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contentBrief = ContentBrief::where('user_id', auth()->id())->findOrFail($id);
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

    /**
     * Generate share tokens for existing briefs (for migration purposes)
     */
    public function generateTokensForExistingBriefs()
    {
        try {
            $briefs = ContentBrief::whereNull('share_token')->get();
            $generatedCount = 0;
            
            foreach ($briefs as $brief) {
                $brief->createShareToken(30); // 30 days expiration
                $generatedCount++;
            }
            
            return response()->json([
                'success' => true,
                'message' => "Generated tokens for {$generatedCount} existing briefs",
                'count' => $generatedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating tokens: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new task for a brief.
     */
    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief_id' => 'required|exists:content_briefs,id',
        ]);

        $brief = ContentBrief::where('id', $validated['brief_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $task = Task::create([
            'brief_id' => $validated['brief_id'],
            'title' => $validated['title'],
        ]);

        return redirect()->back()->with('success', 'Task berhasil ditambahkan.');
    }

    /**
     * Delete a task.
     */
    public function destroyTask($id)
    {
        $task = Task::whereHas('brief', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $task->delete();

        return redirect()->back()->with('success', 'Task berhasil dihapus.');
    }
}

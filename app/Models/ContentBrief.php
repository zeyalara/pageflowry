<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ContentBrief extends Model
{
    protected $fillable = [
        'user_id',
        'token',                    // UUID token untuk akses public (sesuai requirement)
        'public_token',             // UUID token untuk akses public (legacy)
        // Informasi Dasar - Step 2
        'title',                    // fTitle - Judul Konten
        'description',               // fDesc - Deskripsi Tugas Konten
        'brand_id',                 // fBrand - Foreign Key ke brands
        'platform',                 // fPlatform - Platform
        'content_format',           // fFormat - Format Konten
        'target_duration',          // fDuration - Durasi Target
        'production_deadline',       // fDeadProd - Deadline Produksi
        'publish_deadline',          // fDeadPub - Deadline Publish
        
        // Strategi Konten - Step 3
        'objective',                // fObjective - Objective
        'target_audience',          // fAudience - Target Audience
        'key_message',              // fKeyMsg - Key Message
        
        // Brief Kreatif - Step 4
        'hook',                     // fHook - Hook
        'storyline',                // fStory - Storyline
        'visual_direction',         // fVisual - Visual Direction
        
        // Konten & Publishing - Step 5
        'caption',                  // fCaption - Caption
        'cta',                      // fCta - Call to Action
        'hashtags',                 // fHashtag - Hashtag
        
        // Target KPI - Step 6
        'target_views',             // fViews - Target Views
        'target_engagement',        // fEngage - Target Engagement Rate
        
        // Assign & Summary - Step 7
        'creator_email',            // fCreator - Email Content Creator
        
        // System Fields
        'creator_id',               // User yang membuat
        'status',                   // Status
        'share_token',              // Token untuk berbagi link
        'share_token_expires_at',   // Expiration untuk token
    ];

    protected $casts = [
        'production_deadline' => 'date',
        'publish_deadline' => 'date',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the productions for the content brief.
     */
    public function productions(): HasMany
    {
        return $this->hasMany(Production::class, 'content_task_id', 'id');
    }

    /**
     * Generate UUID token untuk akses public
     */
    public function generatePublicToken(): string
    {
        $token = Str::uuid()->toString();
        
        // Save token to database
        $this->public_token = $token;
        $this->save();
        
        return $token;
    }

    /**
     * Get atau generate public token
     */
    public function getPublicToken(): string
    {
        if (!$this->public_token) {
            return $this->generatePublicToken();
        }
        
        return $this->public_token;
    }

    /**
     * Token akses publik (tanpa login) untuk halaman brief creator — pakai APP_KEY (legacy).
     */
    public function publicAccessToken(): string
    {
        return hash_hmac('sha256', (string) $this->getKey(), config('app.key'));
    }

    /**
     * URL lengkap brief publik menggunakan UUID token (untuk email) - SESUAI REQUIREMENT.
     */
    public function publicViewUrl(): string
    {
        $baseUrl = config('app.url');
        $token = $this->token; // Gunakan kolom 'token' sesuai requirement
        return rtrim($baseUrl, '/') . '/brief/' . $token;
    }

    /**
     * Validasi token query ?token= (mendukung token lama md5 untuk email yang sudah terkirim).
     */
    public static function publicViewTokenMatches(self $brief, ?string $token): bool
    {
        if ($token === null || $token === '') {
            return false;
        }

        $expected = hash_hmac('sha256', (string) $brief->getKey(), config('app.key'));
        if (hash_equals($expected, $token)) {
            return true;
        }

        // Legacy: link lama memakai md5(id . created_at)
        $legacy = md5($brief->id.$brief->created_at);

        return hash_equals($legacy, $token);
    }

    /**
     * Generate unique share token for the brief
     */
    public static function generateShareToken(): string
    {
        do {
            $token = Str::random(32); // Generate 32 character random string
        } while (self::where('share_token', $token)->exists());
        
        return $token;
    }

    /**
     * Generate and set share token for this brief
     */
    public function createShareToken(?int $expiresInDays = 30): string
    {
        // Check if share_token column exists
        if (!\Schema::hasColumn('content_briefs', 'share_token')) {
            // Return a temporary token based on existing data
            return md5($this->id . $this->created_at);
        }
        
        $token = self::generateShareToken();
        $this->share_token = $token;
        $this->share_token_expires_at = $expiresInDays ? now()->addDays($expiresInDays) : null;
        $this->save();
        
        return $token;
    }

    /**
     * Check if share token is valid (not expired)
     */
    public function isShareTokenValid(): bool
    {
        // Check if share_token column exists
        if (!\Schema::hasColumn('content_briefs', 'share_token')) {
            // For legacy tokens, always consider valid
            return true;
        }
        
        if (!$this->share_token) {
            return false;
        }
        
        if ($this->share_token_expires_at && now()->isAfter($this->share_token_expires_at)) {
            return false;
        }
        
        return true;
    }

    /**
     * Find brief by share token
     */
    public static function findByShareToken(string $token): ?self
    {
        // Check if share_token column exists
        if (!\Schema::hasColumn('content_briefs', 'share_token')) {
            // Fallback to legacy token method (md5 of id + created_at)
            $briefs = self::all();
            foreach ($briefs as $brief) {
                $legacyToken = md5($brief->id . $brief->created_at);
                if ($legacyToken === $token) {
                    return $brief;
                }
            }
            return null;
        }
        
        $brief = self::where('share_token', $token)->first();
        
        if (!$brief || !$brief->isShareTokenValid()) {
            return null;
        }
        
        return $brief;
    }
}

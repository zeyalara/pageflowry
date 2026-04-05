<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentBrief extends Model
{
    protected $fillable = [
        'user_id',
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
     * Token akses publik (tanpa login) untuk halaman brief creator — pakai APP_KEY.
     */
    public function publicAccessToken(): string
    {
        return hash_hmac('sha256', (string) $this->getKey(), config('app.key'));
    }

    /**
     * URL lengkap brief publik + token (untuk email).
     */
    public function publicViewUrl(): string
    {
        return url('/content-briefs/'.$this->getKey().'/view?token='.urlencode($this->publicAccessToken()));
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
}

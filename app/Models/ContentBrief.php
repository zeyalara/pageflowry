<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentBrief extends Model
{
    protected $fillable = [
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
}

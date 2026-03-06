<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentBrief extends Model
{
    protected $fillable = [
        'title',
        'brand_id',
        'creator_id',
        'platform',
        'content_format',
        'target_duration',
        'production_deadline',
        'publish_deadline',
        'objective',
        'target_audience',
        'key_message',
        'hook',
        'storyline',
        'visual_direction',
        'caption',
        'cta',
        'hashtags',
        'target_views',
        'target_engagement',
        'status',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'pic',
        'contact',
        'target_market',
        'tone',
        'status',
    ];

    protected $appends = ['target', 'tone_array', 'contents', 'created'];

    public function getTargetAttribute()
    {
        return $this->target_market ?? '';
    }

    public function getToneArrayAttribute()
    {
        return $this->tone ? explode(',', $this->tone) : [];
    }

    public function getContentsAttribute()
    {
        return (int) ($this->attributes['contents_count'] ?? 0);
    }

    public function getCreatedAttribute()
    {
        return $this->created_at ? $this->created_at->format('M Y') : 'Unknown';
    }

    public function contentTasks(): HasMany
    {
        return $this->hasMany(ContentTask::class);
    }

    public function contents()
    {
        return $this->hasMany(ContentBrief::class);
    }

    public function activeContents()
    {
        return $this->hasMany(ContentBrief::class)->where('status', 'In Production');
    }

    public function publishedContents()
    {
        return $this->hasMany(ContentBrief::class)->where('status', 'Published');
    }
}
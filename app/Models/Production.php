<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_task_id',
        'video_version',
        'final_duration',
        'production_notes',
        'video_file_path',
        'status',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Get the content task that owns the production.
     */
    public function contentTask(): BelongsTo
    {
        return $this->belongsTo(ContentTask::class);
    }

    /**
     * Get the creator that owns the production.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors to match the expected field names
    public function getVersiVideoAttribute()
    {
        return $this->video_version;
    }

    public function getDurasiFinalAttribute()
    {
        return $this->final_duration;
    }

    public function getCatatanProduksiAttribute()
    {
        return $this->production_notes;
    }

    public function getFileVideoAttribute()
    {
        return $this->video_file_path;
    }
}

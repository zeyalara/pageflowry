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
        'judul_konten',
        'versi_video',
        'durasi_final',
        'catatan_produksi',
        'file_video',
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

    // Accessors for alternate naming
    public function getVideoVersionAttribute()
    {
        return $this->versi_video;
    }

    public function getFinalDurationAttribute()
    {
        return $this->durasi_final;
    }

    public function getProductionNotesAttribute()
    {
        return $this->catatan_produksi;
    }

    public function getVideoFilePathAttribute()
    {
        return $this->file_video;
    }
}

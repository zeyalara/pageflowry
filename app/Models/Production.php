<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ContentBrief;
use App\Models\Task;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'brief_id',
        'content_task_id',
        'task_id',
        'judul_konten',
        'versi_video',
        'durasi_final',
        'catatan_produksi',
        'file_video',
        'status',
        'user_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Get the content brief that owns the production.
     */
    public function brief(): BelongsTo
    {
        return $this->belongsTo(ContentBrief::class, 'brief_id');
    }

    /**
     * Get the content task that owns the production.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(ContentTask::class, 'content_task_id');
    }

    /**
     * Alias for task() - backward compatibility.
     */
    public function contentTask(): BelongsTo
    {
        return $this->task();
    }

    /**
     * Get the new simple task that owns the production.
     */
    public function simpleTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Get the user (admin) who owns this production.
     */
    public function user(): BelongsTo
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

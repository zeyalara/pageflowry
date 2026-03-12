<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_konten',
        'deskripsi',
        'brand_id',
        'creator_id',
        'status',
        'deadline',
        'revision_note',
        'revision_deadline',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'revision_deadline' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the brand that owns the content task.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the creator that owns the content task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the productions for the content task.
     */
    public function productions(): HasMany
    {
        return $this->hasMany(Production::class);
    }
}

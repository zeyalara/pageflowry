<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ContentBrief;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Get the content briefs for the user (admin).
     */
    public function contentBriefs(): HasMany
    {
        return $this->hasMany(ContentBrief::class, 'user_id');
    }

    /**
     * Alias for contentBriefs() - matching requirement "User hasMany Brief".
     */
    public function briefs(): HasMany
    {
        return $this->contentBriefs();
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // ← tambahan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
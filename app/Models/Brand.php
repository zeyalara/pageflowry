<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

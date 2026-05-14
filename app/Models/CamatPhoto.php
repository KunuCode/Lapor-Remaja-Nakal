<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CamatPhoto extends Model
{
    protected $fillable = [
        'image_path',
        'name',
        'position',
        'bio',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}

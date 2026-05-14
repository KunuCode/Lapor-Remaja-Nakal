<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderPhoto extends Model
{
    protected $fillable = [
        'image_path',
        'caption',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}

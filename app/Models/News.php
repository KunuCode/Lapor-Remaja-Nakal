<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'summary',
        'link',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(NewsImage::class)->orderBy('order');
    }

    protected static function booted()
    {
        static::deleting(function ($news) {
            $news->images()->delete();
        });
    }
}

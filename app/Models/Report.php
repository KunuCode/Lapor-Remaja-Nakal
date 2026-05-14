<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'name',
        'email',
        'phone',
        'category',
        'village',
        'address',
        'description',
        'status',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
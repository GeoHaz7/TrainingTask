<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'array'
    ];

    protected $fillable = [
        'title', 'content',
        'status',
        'categories', 'user_id', 'images', 'embed', 'pdf'
    ];

    public function scopeOrder($query)
    {
        $query->orderBy('created_at', 'ASC');
    }

    public function scopeAuthor($query, $user_id)
    {
        $query->where('user_id', 'like', $user_id);
    }

    public function scopeActive($query)
    {
        $query->where('status', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

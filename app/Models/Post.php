<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content',
        'author', 'status', 'categories', 'user_id'
    ];

    public function scopeOrder($query)
    {
        $query->orderBy('created_at', 'ASC');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

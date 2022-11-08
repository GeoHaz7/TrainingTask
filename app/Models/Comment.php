<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;



    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function scopeOrder($query)
    {
        $query->orderBy('created_at', 'ASC');
    }

    public function scopeActive($query)
    {
        $query->where('status', true);
    }

    public function scopePoster($query, $comment_id)
    {
        $query->where('post_id', 'like', $comment_id);
    }
}

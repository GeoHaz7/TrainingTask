<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //ALL Posts
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::order()->paginate(10)
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index()
    {
        $topPosts = Cache::remember('top_posts_today', 1800, function () {
            return Post::whereDate('created_at', now()->toDateString())
                ->orderByDesc('views')
                ->limit(5)
                ->get();
        });

        return view('posts.index', compact('topPosts'));
    }

    public function show(Post $post)
    {
        $post->load(['comments.user']);

        return view('posts.show', compact('post'));
    }
}

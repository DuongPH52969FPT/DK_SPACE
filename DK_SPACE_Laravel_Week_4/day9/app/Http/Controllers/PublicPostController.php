<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->latest()->paginate(10);

        return view('public-posts.index', compact('posts'));
    }

     public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->load(['comments.user']);

        return view('public-posts.show', compact('post'));
    }
}

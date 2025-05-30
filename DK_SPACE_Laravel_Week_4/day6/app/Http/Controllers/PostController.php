<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
      
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
      
    }
}

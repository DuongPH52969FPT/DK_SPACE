<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyAuthorOfComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id() ?? 1, // giả sử user đăng nhập, nếu chưa có thì user_id=1
            'body' => $request->input('body'),
        ]);

        // Dispatch job thông báo tác giả bài viết
        NotifyAuthorOfComment::dispatch($comment);

        return redirect()->route('posts.show', $post)->with('success', 'Bình luận đã được gửi thành công!');
    }
}

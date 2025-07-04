<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;

class PublicPostCommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        if ($post->user && $post->user->id !== auth()->id()) {
            $post->user->notify(new NewCommentNotification($comment));
        }

        return redirect()->route('public-posts.show', $post)->with('success', 'Bình luận đã được gửi!');
    }

    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        if ($comment->post_id !== $post->id) {
            abort(404);
        }

        $comment->delete();

        return redirect()->route('public-posts.show', $post)->with('success', 'Bình luận đã được xóa.');
    }

    public function restore(Post $post, $commentId)
    {
        $comment = Comment::onlyTrashed()->findOrFail($commentId);


        $this->authorize('restore', $comment);

        $comment->restore();

        return redirect()->route('public-posts.show', $post)->with('success', 'Bình luận đã được khôi phục.');
    }
}

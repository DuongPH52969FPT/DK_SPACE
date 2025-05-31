<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class NotifyAuthorOfComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comment;

    /**
     * Create a new job instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $post = $this->comment->post;
        $author = $post->user;

        // Gửi notification
        $author->notify(new CommentNotification($this->comment));

        // Gửi email (ví dụ)
        Mail::raw("Bạn có bình luận mới trên bài viết '{$post->title}'", function ($message) use ($author) {
            $message->to($author->email)
                    ->subject('Thông báo bình luận mới');
        });
    }
}

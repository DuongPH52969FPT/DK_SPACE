<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Gửi mail và lưu notification DB
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("Bạn có bình luận mới trên bài viết: " . $this->comment->post->title)
                    ->action('Xem bài viết', url("/posts/{$this->comment->post->id}"))
                    ->line('Cảm ơn bạn đã sử dụng hệ thống!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post->id,
            'message' => "Có bình luận mới trên bài viết '{$this->comment->post->title}'."
        ];
    }
}

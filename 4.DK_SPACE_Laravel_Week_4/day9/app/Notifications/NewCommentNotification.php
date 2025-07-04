<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     */
     public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    
    /**
     * Get the mail representation of the notification.
     */
     public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bài viết của bạn có bình luận mới')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Bài viết "' . $this->comment->post->title . '" vừa nhận được bình luận mới.')
            ->line('Nội dung: "' . $this->comment->content . '"')
            ->action('Xem bài viết', route('public-posts.show', $this->comment->post))
            ->line('Cảm ơn bạn đã sử dụng hệ thống của chúng tôi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

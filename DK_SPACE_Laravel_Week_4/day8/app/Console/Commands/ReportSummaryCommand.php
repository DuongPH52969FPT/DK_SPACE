<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReportSummaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi email thống kê số bài viết, bình luận, user mới mỗi ngày lúc 01:00';

    /**
     * Execute the console command.
     */
      public function handle()
    {
        $today = now()->toDateString();

        // Đếm số bài viết tạo hôm nay
        $postCount = Post::whereDate('created_at', $today)->count();

        // Đếm số bình luận tạo hôm nay
        $commentCount = Comment::whereDate('created_at', $today)->count();

        // Đếm số user tạo hôm nay
        $userCount = User::whereDate('created_at', $today)->count();

        // Chuẩn bị nội dung email
        $message = "Thống kê ngày $today:\n"
            . "Bài viết mới: $postCount\n"
            . "Bình luận mới: $commentCount\n"
            . "Người dùng mới: $userCount\n";

        // Gửi mail cho admin (giả sử user is_admin)
        $admin = User::where('is_admin', true)->first();

        if ($admin) {
            Mail::raw($message, function ($mail) use ($admin) {
                $mail->to($admin->email)
                     ->subject('Báo cáo thống kê ngày');
            });

            $this->info('Email báo cáo đã được gửi cho admin: ' . $admin->email);
        } else {
            $this->warn('Không tìm thấy admin để gửi báo cáo');
        }

        return 0;
    }
}

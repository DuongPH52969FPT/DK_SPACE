<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $topPosts = Cache::remember('top_posts_today', 1800, function () {
            // Lấy top 5 bài viết có views cao trong ngày hôm nay
            return Post::whereDate('created_at', now()->toDateString())
                ->orderByDesc('views')
                ->take(5)
                ->get();
        });

        return view('home', compact('topPosts'));
    }

    // Hàm này dùng để xóa cache khi có bài mới hoặc views tăng
    public static function clearTopPostsCache()
    {
        Cache::forget('top_posts_today');
    }
}

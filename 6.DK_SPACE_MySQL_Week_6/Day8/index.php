//Viết truy vấn trả về danh sách 10 bài viết được "thích" nhiều nhất hôm nay.

SELECT post_id, user_id, content, likes, created_at
FROM Posts
WHERE DATE(created_at) = CURDATE()
ORDER BY likes DESC
LIMIT 10;

//Cách Caching đề xuất

trong laravel mình có thể sử dụng 

$topPosts = Cache::remember('top_posts_today', 1800, function () {
    return DB::table('posts')
        ->whereDate('created_at', now()->toDateString())
        ->orderByDesc('likes')
        ->limit(10)
        ->get();
});


//EXPLAIN ANALYZE: Phân tích truy vấn

EXPLAIN ANALYZE
SELECT * FROM Posts 
WHERE hashtags LIKE '%fitness%' 
ORDER BY created_at DESC 
LIMIT 20;

//SELECT post_id, user_id, content 
FROM Posts 
WHERE hashtags LIKE '%fitness%' 
ORDER BY created_at DESC 
LIMIT 20;

Chọn kiểu dữ liệu tối ưu:


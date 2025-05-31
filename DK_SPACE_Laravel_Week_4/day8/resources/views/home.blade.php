<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Top 5 Bài viết xem nhiều nhất trong ngày</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
            max-width: 800px;
            margin: 0 auto;
        }

        li {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        li:hover {
            transform: translateY(-3px);
        }

        strong {
            font-size: 20px;
            color: #34495e;
        }

        .views {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 14px;
        }

        p {
            margin: 15px 0;
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .btn-view {
            display: inline-block;
            padding: 10px 18px;
            background-color: #2980b9;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-view:hover {
            background-color: #1c5980;
        }

        .empty-message {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <h1>Top 5 Bài viết xem nhiều nhất hôm nay</h1>
    <ul>
        @forelse ($topPosts as $post)
            <li>
                <strong>{{ $post->title }}</strong>
                <span class="views">{{ $post->views }} lượt xem</span>
                <p>{{ Str::limit($post->content, 150) }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn-view">Xem chi tiết</a>
            </li>
        @empty
            <li class="empty-message">Chưa có bài viết nào hôm nay.</li>
        @endforelse
    </ul>
</body>
</html>

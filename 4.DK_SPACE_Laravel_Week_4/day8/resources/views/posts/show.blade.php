<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $post->title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
            background: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
            margin-bottom: 30px;
        }
        .comments {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
        }
        .comments h2 {
            margin-top: 0;
            font-weight: 600;
            color: #2980b9;
        }
        .comment-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .comment-item:last-child {
            border-bottom: none;
        }
        .comment-author {
            font-weight: 600;
            color: #34495e;
        }
        .comment-body {
            margin-top: 5px;
            color: #555;
        }
        form textarea {
            width: 100%;
            min-height: 80px;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 8px;
            resize: vertical;
        }
        form button {
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #1c5980;
        }
        .message-success {
            color: green;
            margin-bottom: 15px;
        }
        .message-error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <div class="content">
        {!! nl2br(e($post->content)) !!}
        <p><em>{{ $post->views }} lượt xem</em></p>
    </div>

    <div class="comments">
        <h2>Bình luận ({{ $post->comments->count() }})</h2>

        @foreach ($post->comments as $comment)
            <div class="comment-item">
                <div class="comment-author">{{ $comment->user->name }}</div>
                <div class="comment-body">{{ $comment->body }}</div>
                <small><em>{{ $comment->created_at->diffForHumans() }}</em></small>
            </div>
        @endforeach

        <h3>Viết bình luận</h3>

        @if (session('success'))
            <div class="message-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="message-error">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <textarea name="body" required placeholder="Viết bình luận..."></textarea>
            <button type="submit">Gửi bình luận</button>
        </form>
    </div>
</body>
</html>

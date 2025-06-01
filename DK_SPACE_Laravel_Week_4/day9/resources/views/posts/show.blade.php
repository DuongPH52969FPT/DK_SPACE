<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>{{ $post->title }}</h1>
    <p><strong>Trạng thái:</strong> {{ ucfirst($post->status) }}</p>
    <p><strong>Ngày đăng:</strong> {{ $post->created_at->format('d/m/Y') }}</p>
    <hr>
    <p>{!! nl2br(e($post->content)) !!}</p>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">← Quay lại danh sách</a>
</div>
</body>
</html>

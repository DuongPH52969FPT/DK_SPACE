<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Chỉnh sửa bài viết</h1>

    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')

        @include('posts.form')

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>

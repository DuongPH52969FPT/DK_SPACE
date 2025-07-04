<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài viết công khai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📖 Bài viết công khai</h1>

        <div>
    @auth
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                <li><a class="dropdown-item" href="{{ route('posts.index') }}">Bài của tôi</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                        @csrf
                        <button type="submit" class="btn btn-link dropdown-item text-danger p-0 m-0" style="text-align: left;">
                            Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @else
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Đăng nhập</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Đăng ký</a>
    @endauth
</div>

    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="{{ request('search') }}">
            <button class="btn btn-primary">Tìm</button>
        </div>
    </form>

    @if($posts->count())
        <ul class="list-group">
            @foreach($posts as $post)
                <li class="list-group-item mb-4">
                    <h3>{{ $post->title }}</h3>
                    <small>Đăng ngày: {{ $post->created_at->format('d/m/Y') }}</small>

                    <div class="mt-3">
                        <strong>Bình luận ({{ $post->comments()->count() }})</strong>
                    </div>

                    <a href="{{ route('public-posts.show', $post) }}" class="btn btn-sm btn-primary mt-3">Xem chi tiết</a>
                </li>
            @endforeach
        </ul>

        <div class="mt-3">
            {{ $posts->withQueryString()->links() }}
        </div>
    @else
        <div class="alert alert-info mt-3">Chưa có bài viết nào.</div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

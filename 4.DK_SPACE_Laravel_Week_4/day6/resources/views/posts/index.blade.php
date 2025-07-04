<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Danh sách bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Laravel Blog</a>
            <div>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Tạo bài viết</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <h2 class="fw-semibold fs-4 mb-4">Danh sách bài viết</h2>

        @foreach ($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">{{ $post->title }}</h3>
                    <p class="card-text">{{ $post->content }}</p>
                    <p class="text-muted small mb-3">Tác giả: {{ $post->user->name }}</p>

                    <div class="d-flex gap-2">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}">Sửa</a>
                        @endcan

                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                onsubmit="return confirm('Xoá bài viết này?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Xoá
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
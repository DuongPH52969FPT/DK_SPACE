<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Danh sách bài viết</h1>

            <div>

                <a href="{{ route('public-posts.index') }}" class="btn btn-primary">Trang Chủ</a>
                <!-- Nút Logout -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger me-2">Đăng xuất</button>
                </form>

                <!-- Nút Trang Chủ -->
            </div>
        </div>

        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài viết..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary">Tìm</button>
            </div>
        </form>

        <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">+ Viết bài mới</a>

        @if($posts->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Slug</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->slug }}</td>
                            <td>{{ ucfirst($post->status) }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">Xem</a>
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $posts->withQueryString()->links() }}
        @else
            <div class="alert alert-info">Không có bài viết nào.</div>
        @endif
    </div>
</body>

</html>
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
        <p class="text-muted">Đăng ngày: {{ $post->created_at->format('d/m/Y') }}</p>
        <div class="mb-4">
            <h4>Nội dung</h4>
            {!! nl2br(e($post->content)) !!}
        </div>

        <h4>Bình luận ({{ $post->comments()->count() }})</h4>

        @if($post->comments()->count())
            <ul class="list-group mb-4">@foreach($post->comments()->withTrashed()->latest()->get() as $comment)
                    <li class="list-group-item">
                        <small><strong>{{ $comment->user->name }}</strong> - {{ $comment->created_at->diffForHumans() }}</small>
                        <p class="mb-0">{{ $comment->content }}</p>

                        @can('delete', $comment)
                            @if($comment->trashed())
                                <form action="{{ route('public-posts.comments.restore', [$post, $comment->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">Khôi phục</button>
                                </form>
                            @else
                                <form action="{{ route('public-posts.comments.destroy', [$post, $comment]) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            @endif
                        @endcan
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có bình luận nào.</p>
        @endif

        @auth
            <form action="{{ route('public-posts.comments.store', $post) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="comment" class="form-label">Viết bình luận</label>
                    <textarea name="content" id="comment" class="form-control @error('content') is-invalid @enderror"
                        rows="3">{{ old('content') }}</textarea>
                    @if($errors->has('content'))
                        <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                    @endif

                </div>
                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
        @endauth

        <a href="{{ route('public-posts.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
    </div>
</body>

</html>
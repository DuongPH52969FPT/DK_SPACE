@extends('layouts.admin.app')

@section('content')
<div class="container mt-4">
  <form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">Tiêu đề</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Nội dung</label>
        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" placeholder="Nhập nội dung bài viết">{{ old('content') }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Tác giả</label>
        <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" placeholder="Tên tác giả">
    </div>

    <button type="submit" class="btn btn-primary">Đăng bài</button>
</form>
</div>
@endsection

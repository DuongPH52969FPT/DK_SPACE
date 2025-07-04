<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Viết bài mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h1>Viết bài mới</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" id="title" 
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" 
                      class="form-control @error('content') is-invalid @enderror" rows="6">{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" 
                    class="form-select @error('status') is-invalid @enderror">
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Công khai</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Đăng bài</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>

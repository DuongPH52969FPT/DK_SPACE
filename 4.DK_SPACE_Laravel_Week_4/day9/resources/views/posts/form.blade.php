<div class="mb-3">
    <label>Tiêu đề</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">
    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
    @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Nội dung</label>
    <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
    @error('content') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Trạng thái</label>
    <select name="status" class="form-control">
        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Nháp</option>
        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Công khai</option>
    </select>
    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
</div>

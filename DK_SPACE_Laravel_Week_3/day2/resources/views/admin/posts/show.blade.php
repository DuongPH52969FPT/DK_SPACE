@extends('layouts.admin.app')

@section('content')
<div class="container mt-4">
    <h2>{{ $post->title }}</h2>
    <p class="text-muted">Tác giả: {{ $post->author ?? 'Không rõ' }} | Slug: {{ $post->slug }}</p>
    <hr>
    <p>{{ $post->content }}</p>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary mt-3">← Quay lại danh sách</a>
</div>
@endsection
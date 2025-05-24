@extends('errors.app')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="display-4">404</h1>
    <p class="lead">Trang bạn tìm kiếm không tồn tại.</p>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Về trang quản trị</a>
</div>
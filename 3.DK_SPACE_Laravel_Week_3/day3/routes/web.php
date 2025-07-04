<?php

use App\Models\Author;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/delete', function () {
    // Lấy một tác giả bất kỳ có bài viết
    $author = Author::has('posts')->first();

    if (!$author) {
        return 'Không có tác giả nào có bài viết để xóa.';
    }

    $authorId = $author->id;

    // Đếm số lượng bài viết của tác giả trước khi xóa
    $beforeDelete = Post::where('author_id', $authorId)->count();

    // Xóa tác giả
    $author->delete();

    // Đếm lại số bài viết sau khi xóa
    $afterDelete = Post::where('author_id', $authorId)->count();

    return response()->json([
        'author_deleted' => $author->name,
        'posts_before_delete' => $beforeDelete,
        'posts_after_delete' => $afterDelete,
    ]);
});
Route::get('/check', function () {
   
    $authors = Author::more5Posts()
        ->with(['posts' => function ($query) {
            $query->published()->recent();
        }])
        ->get();


    return response()->json($authors);
});
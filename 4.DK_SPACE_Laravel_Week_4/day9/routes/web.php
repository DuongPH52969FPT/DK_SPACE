<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostCommentController;
use App\Http\Controllers\PublicPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('posts', PostController::class);
});

Route::prefix('public-posts')->name('public-posts.')->group(function () {
    Route::get('/', [PublicPostController::class, 'index'])->name('index');
    Route::get('/{post:slug}', [PublicPostController::class, 'show'])->name('show');

    Route::post('/{post:slug}/comments', [PublicPostCommentController::class, 'store'])
        ->middleware('auth')
        ->name('comments.store');
    Route::delete('/{post:slug}/comments/{comment}', [PublicPostCommentController::class, 'destroy'])
        ->middleware('auth')
        ->name('comments.destroy');

    Route::patch('/{post:slug}/comments/{comment}/restore', [PublicPostCommentController::class, 'restore'])
        ->middleware('auth')
        ->name('comments.restore');
});
require __DIR__ . '/auth.php';

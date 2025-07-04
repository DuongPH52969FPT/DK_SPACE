<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);
// Route::get('/posts/{id}/comments', [CommentApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostApiController::class, 'store']);
    // Route::post('/posts/{id}/comments', [CommentApiController::class, 'store']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});
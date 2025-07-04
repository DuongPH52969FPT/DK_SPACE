<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    // Thêm quan hệ 1 bài viết có nhiều bình luận
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Nếu cần, thêm quan hệ bài viết thuộc về user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
{
    static::created(function ($post) {
        Cache::forget('top_posts_today');
    });

    static::updated(function ($post) {
        if ($post->isDirty('views')) {
            Cache::forget('top_posts_today');
        }
    });
}

}

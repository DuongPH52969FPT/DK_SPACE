<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

        public function scopeMore5Posts($query)
    {
        return $query->has('posts', '>=', 5);
    }
}

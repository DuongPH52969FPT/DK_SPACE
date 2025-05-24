<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;


class Post extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
    }

    public function getPublishedAtAttribute($value)
    {
        return $value ? date('d/m/Y H:i', strtotime($value)) : null;
    }

}

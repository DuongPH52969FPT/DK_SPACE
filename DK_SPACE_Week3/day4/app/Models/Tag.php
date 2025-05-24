<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class)->withTimestamps();
    }
}

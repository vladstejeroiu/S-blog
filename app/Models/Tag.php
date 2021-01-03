<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Define the relationship between tags and posts
    public function posts()
    {
        // Many tags can belong to many posts
        return $this->belongsToMany(Post::class);
    }
}

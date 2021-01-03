<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Assign properties that can be mass assigned
    protected $fillable = ['heading', 'subheading', 'body'];


    // Define the relationship between posts and users
    public function author()
    {
        // A post belongs to a user
        // Because author() is used instead of user(), it is necessary to override the FK
        // Laravel would assume author_id to be the FK, but in this case the FK is user_id
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship between posts and tags
    public function tags()
    {
        // Many posts can belong to many tags
        return $this->belongsToMany(Tag::class)->withTimestamps(); // Fills timestamp columns
    }
}

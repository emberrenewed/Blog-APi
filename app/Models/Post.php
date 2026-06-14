<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Columns we are allowed to fill.
    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
    ];

    // Each post belongs to one user (the author).
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each post can have many comments.
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

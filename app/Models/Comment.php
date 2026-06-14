<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Columns we are allowed to fill.
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];

    // Each comment belongs to one user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each comment belongs to one post.
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

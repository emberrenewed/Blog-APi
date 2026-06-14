<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Columns we are allowed to fill.
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Columns to hide when sending the user as JSON.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Laravel will automatically hash the password for us.
    protected $casts = [
        'password' => 'hashed',
    ];

    // One user has many posts.
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // One user has many comments.
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

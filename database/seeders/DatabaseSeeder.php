<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        );

        $post = Post::firstOrCreate(
            ['title' => 'My First Post'],
            ['content' => 'Hello world!', 'user_id' => $user->id]
        );

        Comment::firstOrCreate(
            ['comment' => 'Nice post!', 'post_id' => $post->id],
            ['user_id' => $user->id]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // This puts some example data in the database so it is not empty.
    // We use firstOrCreate so it is SAFE to run again and again
    // (it will not make copies or crash if the data already exists).
    public function run(): void
    {
        // 1) Make one test user (login password is: password).
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        );

        // 2) Make one example post for that user.
        $post = Post::firstOrCreate(
            ['title' => 'My First Post'],
            ['content' => 'Hello world! This is my very first blog post.', 'user_id' => $user->id]
        );

        // 3) Make one example comment on that post.
        Comment::firstOrCreate(
            ['comment' => 'Nice post!', 'post_id' => $post->id],
            ['user_id' => $user->id]
        );
    }
}

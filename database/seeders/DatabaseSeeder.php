<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // This puts some example data in the database so it is not empty.
    public function run(): void
    {
        // 1) Make one test user.
        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => 'password',   // login password is: password
        ]);

        // 2) Make one example post for that user.
        $post = Post::create([
            'title'   => 'My First Post',
            'content' => 'Hello world! This is my very first blog post.',
            'user_id' => $user->id,
        ]);

        // 3) Make one example comment on that post.
        Comment::create([
            'comment' => 'Nice post!',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}

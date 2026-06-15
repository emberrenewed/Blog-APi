<?php

namespace App\Actions\Post;

use App\Models\Post;

class DeletePostAction
{
    public function handle(Post $post): void
    {
        $post->delete();
    }
}

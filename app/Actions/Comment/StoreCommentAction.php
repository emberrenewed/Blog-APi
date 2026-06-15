<?php

namespace App\Actions\Comment;

use App\Models\Comment;
use App\Models\Post;

class StoreCommentAction
{
    public function handle(Post $post, string $comment, int $userId): Comment
    {
        return $post->comments()->create([
            'comment' => $comment,
            'user_id' => $userId,
        ]);
    }
}

<?php

namespace App\Actions\Comment;

use App\Models\Comment;

class DeleteCommentAction
{
    public function handle(Comment $comment): void
    {
        $comment->delete();
    }
}

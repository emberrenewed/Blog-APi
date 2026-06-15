<?php

namespace App\Http\Controllers\Api\Comment;

use App\Actions\Comment\DeleteCommentAction;
use App\Actions\Comment\FetchCommentsAction;
use App\Actions\Comment\StoreCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function fetch(Post $post, FetchCommentsAction $action)
    {
        return CommentResource::collection($action->handle($post));
    }

    public function store(StoreCommentRequest $request, Post $post, StoreCommentAction $action)
    {
        $comment = $action->handle($post, $request->validated()['comment'], $request->user()->id);

        return new CommentResource($comment->load('user'));
    }

    public function destroy(Comment $comment, DeleteCommentAction $action)
    {
        $this->authorize('delete', $comment);

        $action->handle($comment);

        return response()->json(['message' => 'Comment deleted.']);
    }
}

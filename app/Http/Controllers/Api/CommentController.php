<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // GET /api/posts/{post}/comments  -> all comments on a post
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get();

        return response()->json($comments);
    }

    // POST /api/posts/{post}/comments  -> add a comment (must be logged in)
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = $post->comments()->create([
            'comment' => $data['comment'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    // DELETE /api/comments/{comment}  -> delete a comment (only the owner can)
    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'This is not your comment.'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted.']);
    }
}

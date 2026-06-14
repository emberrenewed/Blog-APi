<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // GET /api/posts  -> show all posts (newest first)
    public function index(Request $request)
    {
        $posts = Post::with('user')->latest();

        // If there is a ?search=word, only keep posts with that word in the title.
        if ($request->search) {
            $posts->where('title', 'like', '%' . $request->search . '%');
        }

        return response()->json($posts->get());
    }

    // GET /api/posts/{post}  -> show one post
    public function show(Post $post)
    {
        return response()->json($post->load('user'));
    }

    // POST /api/posts  -> create a new post (must be logged in)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image',
        ]);

        // Save the picture if one was sent.
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = $request->user()->posts()->create($data);

        return response()->json($post->load('user'), 201);
    }

    // PUT /api/posts/{post}  -> edit a post (only the owner can)
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'This is not your post.'], 403);
        }

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return response()->json($post->load('user'));
    }

    // DELETE /api/posts/{post}  -> delete a post (only the owner can)
    public function destroy(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'This is not your post.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted.']);
    }
}

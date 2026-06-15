<?php

namespace App\Http\Controllers\Api\Post;

use App\Actions\Post\DeletePostAction;
use App\Actions\Post\FetchPostsAction;
use App\Actions\Post\StorePostAction;
use App\Actions\Post\UpdatePostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function fetch(Request $request, FetchPostsAction $action)
    {
        return PostResource::collection($action->handle($request->input('search')));
    }

    public function show(Post $post)
    {
        return new PostResource($post->load('user'));
    }

    public function store(StorePostRequest $request, StorePostAction $action)
    {
        $post = $action->handle(
            $request->validated(),
            $request->user()->id,
            $request->file('image')
        );

        return new PostResource($post->load('user'));
    }

    public function update(UpdatePostRequest $request, Post $post, UpdatePostAction $action)
    {
        $this->authorize('update', $post);

        $post = $action->handle($post, $request->validated(), $request->file('image'));

        return new PostResource($post->load('user'));
    }

    public function destroy(Request $request, Post $post, DeletePostAction $action)
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403, 'This is not your post.');
        }

        $action->handle($post);

        return response()->json(['message' => 'Post deleted.']);
    }
}

<?php

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

class UpdatePostAction
{
    public function handle(Post $post, array $data, ?UploadedFile $image): Post
    {
        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        $post->update($data);

        return $post;
    }
}

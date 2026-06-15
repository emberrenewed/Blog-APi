<?php

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

class StorePostAction
{
    public function handle(array $data, int $userId, ?UploadedFile $image): Post
    {
        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        $data['user_id'] = $userId;

        return Post::create($data);
    }
}

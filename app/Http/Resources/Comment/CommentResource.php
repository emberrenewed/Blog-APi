<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'comment'    => $this->comment,
            'post_id'    => $this->post_id,
            'created_at' => $this->created_at,
            'user'       => new UserResource($this->whenLoaded('user')),
        ];
    }
}

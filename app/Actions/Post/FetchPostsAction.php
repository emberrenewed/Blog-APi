<?php

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class FetchPostsAction
{
    public function handle(?string $search): Collection
    {
        return Post::with('user')
            ->when($search, fn($query, $s) => $query->where('title', 'like', "%$s%"))
            ->latest()
            ->get();
    }
}

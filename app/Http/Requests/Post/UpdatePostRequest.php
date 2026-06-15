<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'   => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'image'   => 'nullable|image',
        ];
    }
}

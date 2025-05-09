<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guard()->check();
    }

    public function prepareForValidation()
    {


        // Merge the sanitized content back
        $this->merge([
            'content' => sanitize_content($this->input('content')),
        ]);
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ];
    }
}

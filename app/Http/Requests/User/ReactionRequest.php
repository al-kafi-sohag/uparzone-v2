<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ReactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|integer|exists:posts,id',
            'reaction' => 'required|in:true,false,0,1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'post_id.required' => 'Post ID is required',
            'post_id.integer' => 'Post ID must be a number',
            'post_id.exists' => 'Post not found',
            'reaction.required' => 'Reaction status is required',
            'reaction.in' => 'Invalid reaction value. Must be true/false or 1/0',
        ];
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PostUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'title' => sanitize_content($this->input('title')),
            'description' => sanitize_content($this->input('description')),
            'category_id' => $this->category == 'all' ? null : $this->category,
            'religion_id' => $this->religion == 'all' ? null : $this->religion,
            'mood_id' => $this->mood == 'all' ? null : $this->mood,
            'gender_id' => $this->gender == 'all' ? null : $this->gender,
            'is_adult_content' => $this->adult_content == 'true' ? true : false,
        ]);
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'temp_id' => 'required|exists:temporary_medias,temp_id',
            'category_id' => 'nullable|exists:post_categories,id',
            'religion_id' => 'nullable|exists:religions,id',
            'mood_id' => 'nullable|exists:moods,id',
            'gender_id' => 'nullable|exists:genders,id',
            'is_adult_content' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title.',
            'title.max' => 'Title must be at most 255 characters.',
            'description.max' => 'Description must be at most 500 characters.',
            'temp_id.required' => 'Please select a file.',
            'category_id.exists' => 'Invalid category.',
            'religion_id.exists' => 'Invalid religion.',
            'mood_id.exists' => 'Invalid mood.',
            'gender_id.exists' => 'Invalid gender.',
            'is_adult_content.boolean' => 'Invalid adult content value.',
        ];
    }
}

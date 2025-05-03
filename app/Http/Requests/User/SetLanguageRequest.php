<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SetLanguageRequest extends FormRequest
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
        $lookup = [
            'english' => 'en',
            'bangla' => 'bn',
            'hindi' => 'hi',
        ];
        $this->merge([
            'language' => $lookup[$this->language],
        ]);
    }
    public function rules(): array
    {
        return [
            'language' => 'required|string|in:en,bn,hi',
        ];
    }

    public function messages(): array
    {
        return [
            'language.required' => 'Language is required',
            'language.in' => 'Invalid language',
        ];
    }
}

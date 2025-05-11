<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReferenceCodeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reference_code' => 'required|string|max:255|exists:users,reference_code',
        ];
    }

    public function messages()
    {
        return [
            'reference_code.required' => 'Please enter a reference code.',
            'reference_code.exists' => 'The reference code does not match.',
        ];
    }
}

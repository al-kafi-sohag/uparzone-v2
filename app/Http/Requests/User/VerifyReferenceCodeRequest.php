<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class VerifyReferenceCodeRequest extends FormRequest
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
            'reference_code' => 'required|string|exists:users,reference_code',
        ];
    }

    public function messages(): array
    {
        return [
            'reference_code.required' => 'Reference code is required',
            'reference_code.exists' => 'Reference code does not exist',
        ];
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PostFileUploadRequest extends FormRequest
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
            'file' => [
                'required',
                'file',
                'max:51200', // 50MB max
                'mimes:jpeg,png,jpg,gif,mp4,mov,webm',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => __( 'Please select a file to upload.'),
            'file.file' => __('The uploaded content must be a valid file.'),
            'file.max' => __('The file size cannot exceed 50MB.'),
            'file.mimes' => __('Only JPEG, PNG, JPG, GIF, MP4, MOV, and WEBM files are allowed.'),
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }
}

<?php

namespace App\Http\Requests\User;

use App\Models\Mood;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'age' => 'required|numeric|min:13|max:120',
            'gender' => 'required|string|in:male,female,other',
            'profession' => 'required|string|in:student,professional,business,homemaker,retired,other',
            'mood' => 'required|string|exists:moods,id,status,' . Mood::STATUS_ACTIVE,
        ];
    }
}

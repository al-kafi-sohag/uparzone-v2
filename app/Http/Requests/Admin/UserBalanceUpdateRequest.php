<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserBalanceUpdateRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'note' => 'required|string|max:1000',
            'type' => 'required|in:credit,debit',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID is required',
            'user_id.exists' => 'User ID does not exist',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'note.required' => 'Note is required',
            'note.string' => 'Note must be a string',
            'note.max' => 'Note must be less than 1000 characters',
            'type.required' => 'Type is required',
            'type.in' => 'Type must be credit or debit',
        ];
    }
}

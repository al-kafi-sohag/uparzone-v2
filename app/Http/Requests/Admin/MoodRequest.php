<?php

namespace App\Http\Requests\Admin;

use App\Models\Mood;
use Illuminate\Foundation\Http\FormRequest;

class MoodRequest extends FormRequest
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
            'name' => 'required|unique:moods,name,' . $this->route('id', null),
            'emoji' => 'required|string',
            'order' => 'nullable|integer',
            'status' => 'required|in:' . Mood::STATUS_ACTIVE . ',' . Mood::STATUS_INACTIVE,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'emoji.required' => 'Emoji is required',
            'emoji.string' => 'Emoji provide a valid emoji',
            'order.integer' => 'Order must be a number',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be 0 or 1',
        ];
    }
}

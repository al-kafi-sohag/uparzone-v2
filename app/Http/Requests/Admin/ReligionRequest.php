<?php

namespace App\Http\Requests\Admin;

use App\Models\Religion;
use Illuminate\Foundation\Http\FormRequest;

class ReligionRequest extends FormRequest
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
            'name' => 'required|unique:religions,name,' . $this->route('id', null),
            'status' => 'required|in:' . Religion::STATUS_ACTIVE . ',' . Religion::STATUS_INACTIVE,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be 0 or 1',
        ];
    }
}

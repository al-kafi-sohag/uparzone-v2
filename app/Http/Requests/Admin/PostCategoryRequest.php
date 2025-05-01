<?php

namespace App\Http\Requests\Admin;

use App\Models\PostCategory;
use Illuminate\Foundation\Http\FormRequest;

class PostCategoryRequest extends FormRequest
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
            'name' => 'required|unique:post_categories,name,' . $this->route('id', null),
            'order' => 'nullable|integer',
            'status' => 'required|in:' . PostCategory::STATUS_ACTIVE . ',' . PostCategory::STATUS_INACTIVE,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'order.integer' => 'Order must be a number',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be 0 or 1',
        ];
    }
}

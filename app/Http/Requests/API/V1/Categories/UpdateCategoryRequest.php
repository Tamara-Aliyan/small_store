<?php

namespace App\Http\Requests\API\V1\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $id = request()->segment(4);
        return [
            'name' => [
                'string',
                'between:5,20',
                "unique:categories,name,{$id}"
            ],
            'image' => [
                'image',
                'dimensions:max_width:3840,max_height:2160',
                'mimes:png,jpg,gif',
                'max:2765'
            ],
            'parent_id' => [
                'integer',
                'exists:categories,id',
                "not_in:$id"
            ]
        ];
    }
}

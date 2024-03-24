<?php

namespace App\Http\Requests\API\V1\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id' => [
                'exists:categories,id'
            ],
            'user_id' => [
                'exists:users,id'
            ],
            'name' => [
                'string',
                'between:3,15'
            ],
            'price' => [
                'numeric',
                'between:1,5000'
            ],
            'images' => [
                'array',
                'min:2'
            ],
            'images.*' => [
                'image',
                'dimensions:max_width:3840,max_height:2160',
                'mimes:png,jpg,gif',
                'max:2765'
            ]
        ];
    }
}

<?php

namespace App\Http\Requests;

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
            'name' => 'required|string',
            'price' => 'required|numeric',
            'url' => 'required|unique:products,url'.$this->route('product')->id,
            'short_description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'average_rating' => 'nullable|numeric',
            'total_reviews' => 'nullable|integer',
            'seller_name' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'website_id' => 'required|exists:websites,id',
        ];
    }
}

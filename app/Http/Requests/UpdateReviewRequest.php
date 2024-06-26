<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'product_id' => 'required|array',
            'text' => 'required|string',
            'is_fake' => 'required|boolean',
            'reviewer' => 'required|string',
            'title' => 'required|string',
            'summarize' => 'required|string',
            'positivity' => 'required|numeric',
            'negativity' => 'required|numeric',
            'url' => 'nullable|url|unique:reviews,url,'.$this->route('review')->id,
            'stars' => 'required|numeric',
            'date' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'url',
        ];
    }

    function prepareForValidation()  {
        $this->merge([
            'images' => json_encode($this->images),
        ]);
   }
}

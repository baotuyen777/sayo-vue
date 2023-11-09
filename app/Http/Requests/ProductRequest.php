<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'price' => 'required|integer',

        ];
    }

    public function messages(){
        return [
            'name.required' =>' Vui lòng nhập tiêu đề',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\ReCaptcha;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
//            'avatar_id' => 'required',
//            'file_ids' => 'required',
            'category_id' => 'required',
//            'address' => 'required',
            'price' => 'required|integer',

           'g-recaptcha-response' => ['required', new ReCaptcha]
        ];
    }

    public function messages(){
        return [
            'name.required' =>' Vui lòng nhập tiêu đề',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'password' => 'required|min:6|confirmed|bail',
            'password_confirmation' => 'required|min:6|bail',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu không được dưới :min',
            'password.confirmed' => 'Mật khẩu không giông nhau',
            'password_confirmation' => "Xác nhận mật khẩu là bắt buộc"
        ];
    }
}

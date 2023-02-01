<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_login' => 'email',
            'password_login' => 'min:8|max:32'
        ];
    }

    public function messages()
    {
        return [
            'email_login.email.email' => 'wrong email format',
            'password_login.min' => 'password must be at least 8 characters',
            'password_login.max' => 'max length password is 32'
        ];
    }
}

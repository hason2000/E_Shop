<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
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
            'username' => 'required|min:8|max:32',
            'password' => 'required|min:6|max:32'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username must be not empty',
            'username.min' => 'Username has at least 8 characters',
            'username.max' => 'Username has maximum of 32 characters',
            'password.required' => 'Password must be not empty',
            'password.min' => 'Password has at least 6 characters',
            'password.max' => 'Password has maximum of 32 characters',
        ];
    }
}

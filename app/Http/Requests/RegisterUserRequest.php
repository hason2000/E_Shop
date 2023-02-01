<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|max:32',
            'phone_number' => 'required|numeric|digits_between:9,20',
            'date_of_birth' => 'required',
            // 'address' => 'required|max: 64',
            'email' => 'email|unique:users|required',
            'password' => 'required|min:8|max:32'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is not empty',
            'name.max' => 'max length is 32',
            'phone_number.required' => 'phone number is not empty',
            'phone_number.numeric' => 'phone number include numbers only',
            'phone_number.digits_between' => 'phonenumber must be at least 9 number and max length is 20',
            'date_of_birth.required' => 'Date is not empty',
            // 'address.required' => 'address is not empty',
            // 'address.max' => 'max length is 64',
            'email.email' => 'wrong email format',
            'email.unique' => 'email already exists',
            'password.required' => 'password is empty',
            'password.min' => 'password must be at least 8 characters',
            'password.max' => 'Max length password is 32 '
        ];
    }
}

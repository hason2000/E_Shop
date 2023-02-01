<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
            'phone_number' => 'numeric|digits_between:9,20',
            'avatar' => 'mimes:png,jpeg,gif',
            'username' => ['sometimes', 'min:8', 'max:32', Rule::unique('admins')->ignore($this->id)],
            'email' => ['sometimes', 'email', Rule::unique('admins')->ignore($this->id)],
            'role-admin' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'phone_number.numeric' => 'wrong phone number format',
            'phone_number.digits_between' => 'phone numbers are between 9 and 20',
            'avatar.mimes' => 'wrong image format',
            'email.unique' => 'email already exists',
        ];
    }
}

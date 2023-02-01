<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->id == auth()->id() || auth()->guard('admin')->check()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'required',
            'address.*.*' => 'required',
            'address' => 'array',
            'address_default' => 'nullable',
            'password' => 'nullable|min:8|max:32'
        ];
    }
}

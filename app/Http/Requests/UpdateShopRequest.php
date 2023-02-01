<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
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
            'name' => 'required',
            'web_site' => 'nullable|url',
            'address.*' => 'required',
            'detail' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is not empty',
            'web_site.url' => 'wrong url format',
            'address.*.required' => 'This field must be filled out',
            'detail.required' => 'This field must be filled out'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'amount' => 'required|numeric|gt:0',
            'size' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'amount is required',
            'amount.numeric' => 'amount must format number',
            'amount.gt' => 'amount greater than 1',
            'size.required' => 'please chose size'
        ];
    }
}

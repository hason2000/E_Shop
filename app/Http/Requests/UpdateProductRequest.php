<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'price' => 'required|numeric|gt:0',
            'condition' => 'required|in:0,1',
            'size.*' => 'required|integer|gte:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is not empty',
            'price.required' => 'price is not empty',
            'price.numeric' => 'price is only number',
            'price.gt' => 'price is greater than 0',
            'condition.required' => 'conditon is not empty',
            'condition.in' => 'condition is 0 or 1',
            'size.*.required' => 'Amount size is not empty',
            'size.*.integer' => 'Amount size is integer number',
            'size.*.gte' => 'Amount size is greater than or equal 0',
        ];
    }
}

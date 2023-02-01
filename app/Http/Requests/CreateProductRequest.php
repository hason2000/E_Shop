<?php

namespace App\Http\Requests;

use App\Rules\SumAmountSize;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'img_link' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // max : 10000kb
            'name' => 'required',
            'shop_id' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required|numeric|gt:0',
            'condition' => 'required|in:0,1',
            'size' => [new SumAmountSize],
            'size.*' => 'required|integer|gte:0',
            'sub_img.*' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];
    }

    public function messages()
    {
        return [
            'img_link.required' => 'please choose img',
            'img_link.mimes' => 'wrong image format, suitable formats(jpeg,jpg,png,gif)',
            'img_link.max' => 'image size is too heavy(<10000kb)',
            'name.required' => 'name is not empty',
            'shop_id.required' => 'please choose shop',
            'category_id.required' => 'please choose category',
            'brand_id.required' => 'please choose required',
            'price.required' => 'price is not empty',
            'price.numeric' => 'price is only number',
            'price.gt' => 'price is greater than 0',
            'condition.required' => 'conditon is not empty',
            'condition.in' => 'condition is 0 or 1',
            'size.*.required' => 'Amount size is not empty',
            'size.*.integer' => 'Amount size is integer number',
            'size.*.gte' => 'Amount size is greater than or equal 0',
            'sub_img.*.mimes' => 'wrong image format',
            'sub_img.*.max' => 'img size is too heavy'
        ];
    }
}

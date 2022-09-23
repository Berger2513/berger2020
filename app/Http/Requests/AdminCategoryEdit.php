<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryEdit extends FormRequest
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
            'sort' => 'required||max:10',
            'description' => 'required||max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> "名称必须填写",
            'sort.required'=> "排序必须填写",
            'sort.max'=> "最长不能超过10",
            'description.required'=> "描述必须填写",
            'description.max'=> "最长不能超过100",
        ];
    }
}

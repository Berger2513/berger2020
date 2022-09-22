<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use think\Validate;
class AdminCategory extends FormRequest
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
            'name' => 'required|unique:categorys|max:255',
            'sort' => 'required||max:10',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> "名称必须填写",
            'name.unique'=> "名称必须唯一",
            'name.max'=> "最长不能超过255",
            'sort.required'=> "排序必须填写",
            'sort.max'=> "最长不能超过10",
        ];
    }

}

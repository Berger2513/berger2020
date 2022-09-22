<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminGoods extends FormRequest
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
            'name' => 'required|unique:goods',
            'category_id' => 'required|exists:categorys,category_id',
            'cover' => 'required',
            'taobao_id' => 'required',
            'description' => 'required',
            'content' => 'required',
            'options' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> "名称必须填写",
            'name.unique'=> "名称必须唯一",
            'category_id.required'=> "分类id必须填写",
            'taobao_id.required'=> "淘宝id必须填写",
            'category_id.exists'=> "分类id必须存在",
            'cover.required'=> "封面必须输入",
            'description.required'=> "描述必须输入",
            'content.required'=> "内容必须输入",
            'options.required'=> "规格必须输入",
        ];
    }

}

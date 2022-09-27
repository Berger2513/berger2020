<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use think\Validate;

class AdminActivityEdit extends FormRequest
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
            'banner' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'goods_id' => 'required',
            'images' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "名称必须填写",

            'start_date.required' => "开始时间必须填写",
            'end_date.required' => "结束时间时间必须填写",
            'banner.required' => "banner必须填写",
            'goods_id.required' => "goods_id必须填写",
            'images.required' => "图片必须填写",
            'description.required' => "描述必须填写",
        ];
    }

}

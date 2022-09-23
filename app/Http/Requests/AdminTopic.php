<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use think\Validate;

class AdminTopic extends FormRequest
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
            'cover' => 'required',
            'modules' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "名称必须填写",
            'cover.required' => "封面必须填写",
            'modules.required' => "模块必须填写",
        ];
    }

}

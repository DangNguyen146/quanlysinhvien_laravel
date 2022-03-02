<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostPostRequest extends FormRequest
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
            'title' => 'required|unique:posts|max:255',
        
            'stFile' => 'required|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Tên không được phép để trống',
            'title.unique' => 'Tên không được phép trùng',
            'title.max' => 'Tên không được phép quá 255 kí tự',

         

            'stFile.required' => 'Không có file',
            'stFile.image' => 'Không phải file',
            'stFile.max' => 'File kích thước tối đa là 2MB',
        ];
    }
}

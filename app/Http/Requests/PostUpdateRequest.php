<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'title' => 'max:255',
            'slug' => 'min:2|max:255|not_regex:/[^a-z0-9-]/',
            'imgfile' => 'image|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Tên được phép để trống',
            'title.unique' => 'Tên không được phép trùng',
            'title.max' => 'Tên không được phép quá 255 kí tự',

            'slug.required' => 'Đường dẫn không được phép để trống',
            'slug.unique' => 'Đường dẫn không được phép trùng',
            'slug.min' => 'Đường dẫn có ít nhất 2 ký tự',
            'slug.max' => 'Đường dẫn nhiều nhất 255 ký tự',
            'slug.not_regex' => 'Đường dẫn chứa ký tự không phù hợp(a-z|A-Z|0-9)',

            'imgfile.image' => 'Không phải ảnh',
            'imgfile.max' => 'File kích thước tối đa là 2MB',
        ];
    }
}

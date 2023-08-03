<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordAdminRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password'      =>  'required',
            'new_password'      =>  'required|min:6',
            're_password'       =>  'required|same:new_password',
        ];
    }
    public function messages()
    {
        return [
            'new_password.*'    =>  'Mật khẩu phải từ 6 ký tự',
            're_password.*'     =>  'Mật khẩu nhập lại không giống',
        ];
    }
}

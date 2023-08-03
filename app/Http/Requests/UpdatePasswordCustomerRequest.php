<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordCustomerRequest extends FormRequest
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

    public function rules(): array
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

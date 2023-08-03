<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhanHoiRequest extends FormRequest
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
            'ho_va_ten'          =>  'required|min:5|max:100',
            'email'              =>  'required|email|unique:admins,email',
            'so_dien_thoai'      =>  'required|digits:10',
            'ghi_chu'            =>  'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.*'         =>  'Họ và tên phải từ 5 ký tự',
            'email.*'             =>  'Email không đúng định dạng hoặc đã tồn tại',
            'so_dien_thoai.*'     =>  'Số điện thoại chỉ được 10 số',
            'ghi_chu.*'           =>  'Phải nhập ít nhất 2 kí tự',
        ];
    }
}

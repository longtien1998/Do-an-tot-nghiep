<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'. $this->id,
            'phone' => 'nullable|regex:/^0\d{9}$/',
            'password' => 'required|min:8',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gerder' => 'nullable',
            'birthday' => 'nullable|date|before_or_equal:today',
        ];
    }
    public function messages() {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được dài quá 255 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'image.max' => 'Hình ảnh không được quá 2MB',
            'image.mimes' => 'Hình ảnh không đúng định dạng',
            'birthday.before_or_equal' => 'Ngày sinh không được quá ngày hiện tại',
        ];
    }
}

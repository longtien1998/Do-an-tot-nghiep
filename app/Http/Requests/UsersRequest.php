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
            'firstname' => 'nullable|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'. $this->id,
            'phone' => 'nullable|digits:10',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'gerder' => 'nullable|max:10',
            'birthday' => 'nullable|date|before_or_equal:today',
        ];
    }
    public function messages() {
        return [
            'firstname.max' => 'Tên không được dài quá 255 ký tự',
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được dài quá 255 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone.digits' => 'Số điện thoại không được dài quá 10 ký tự',
            'image.max' => 'Hình ảnh không được quá 2MB',
            'image.mimes' => 'Hình ảnh không đúng định dạng',
            'gerder.max' => 'Giới tính không được quá 10 ký tự',
            'birthday.before_or_equal' => 'Ngày sinh không được quá ngày hiện tại',
        ];
    }
}

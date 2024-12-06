<?php

namespace App\Http\Requests\Pulishers;

use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
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
            'publisher_name' => 'required|string|unique:publishers,publisher_name,'. $this->route(param: 'id'),
            'alias_name' => 'required|string|unique:publishers,alias_name,' . $this->route('id'),
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'website' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'logo' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ];
    }
    public function messages(): array{
        return [
            'publisher_name.required' => 'Tên Nhà xuất bản không được để trống.',
            'publisher_name.unique' => ' Tên Nhà xuất bản đã tồn tại.',
            'publisher_name.string' => ' Tên Nhà xuất bản không đúng định dạng (chuỗi ký tự).',
            'alias_name.required' => 'Tên gọi khác không được để trống.',
            'alias_name.unique' => 'Tên gọi khác đã tồn tại.',
            'alias_name.string' => 'Tên gọi khác không đúng định dạng (chuỗi ký tự).',
            'country.required' => 'Quốc gia không được để trống.',
            'country.string' => 'Quốc gia không đúng định dạng (chuỗi ký tự).',
            'city.required' => 'Thành phố không được để trống.',
            'city.string' => 'Thành phố không đúng định dạng (chuỗi ký tự).',
            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ không đúng định dạng (chuỗi ký tự).',
            'website.required' => 'Website không được để trống.',
            'website.string' => 'Website không đúng định dạng (chuỗi ký tự).',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required' => 'Điện thoại không được để trống.',
            'phone.digits' => 'Số điện thoại không đủ 10 ký tự',
            'logo.required' => 'Logo không được để trống.',
            'logo.mimes' => 'Hình ảnh không đúng định dạng',
            'description.required' => 'Mô tả không được để trống.',
            'description.string' => 'Mô tả không đúng định dạng (chuỗi ký tự).',
        ];
    }
}

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
            'email' => 'required|string',
            'phone' => 'required|string',
            'logo' => 'required',
            'description' => 'required|string',
        ];
    }
    public function messages(): array{
        return [
            'publisher_name.required' => 'Tên Nhà xuất bản không được để trống.',
            'publisher_name.unique' => ' Tên Nhà xuất bản đã tồn tại.',
            'publisher_name.string' => ' Tên Nhà xuất bản không đúng định dạng (chuỗi ký tự).',
            'alias_name.required' => 'Tên đại diện không được để trống.',
            'alias_name.unique' => 'Tên đại diện đã tồn tại.',
            'alias_name.string' => 'Tên đại diện không đúng định dạng (chuỗi ký tự).',
            'country.required' => 'Quốc gia không được để trống.',
            'country.string' => 'Quốc gia không đúng định dạng (chuỗi ký tự).',
            'city.required' => 'Thành phố không được để trống.',
            'city.string' => 'Thành phố không đúng định dạng (chuỗi ký tự).',
            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ không đúng định dạng (chuỗi ký tự).',
            'website.required' => 'Website không được để trống.',
            'website.string' => 'Website không đúng định dạng (chuỗi ký tự).',
            'email.required' => 'Email không được để trống.',
            'email.string' => 'Email không đúng định dạng (chuỗi ký tự).',
            'phone.required' => 'Điện thoại không được để trống.',
            'phone.string' => 'Điện thoại không đúng định dạng (chuỗi ký tự).',
            'logo.required' => 'Logo không được để trống.',
            'description.required' => 'Mô tả không được để trống.',
            'description.string' => 'Mô tả không đúng định dạng (chuỗi ký tự).',
        ];
    }
}

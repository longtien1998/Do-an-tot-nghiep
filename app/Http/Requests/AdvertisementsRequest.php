<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementsRequest extends FormRequest
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
            'ads_name' => 'required|max:255',
            'ads_description' => 'required|max:255',
            'file_path' => 'required|mimes:mp3|max:10240',
            'image_path' => 'nullable|mimes:jpg,png,jpeg,gif|max:5120'
        ];
    }
    public function messages()
    {
        return [
            'ads_name.required' => 'Vui lòng nhập tên quảng cáo',
            'ads_name.max' => 'Tên quảng cáo không được quá 255 ký tự',
            'ads_description.required' => 'Vui lòng nhập mô tả quảng cáo',
            'ads_description.max' => 'Mô tả quảng cáo không được dài quá 255 ký tự',
            'file_path.max'   => 'Dung lượng tối đa cho video là 10MB.',
            'file_path.required' => 'Vui lòng thêm đường dẫn quảng cáo',
            'file_path.mimes' => 'File quảng cáo phải là mp3',
            'image_path.max'   => 'Dung lượng tối đa cho hình ảnh là 5MB',
            'image_path.mimes' => 'File hình ảnh phải là jpg, png, jpeg,gif',
        ];
    }
}

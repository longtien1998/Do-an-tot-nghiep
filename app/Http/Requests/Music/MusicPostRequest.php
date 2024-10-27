<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class MusicPostRequest extends FormRequest
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
            'song_name' => 'required|max:255|unique:songs,song_name|string',
            'description' => 'required|max:255|string',
            'singer_id' => 'required',
            'category_id' => 'required',
            'release_day' => 'required',
            'country_id' => 'required|string',
            'provider' => 'required|string',
            'composer' => 'required|string',
            'file_basic' => 'required',
            'song_image' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'song_name.required' => 'Tên bài hát không được để trống',
            'song_name.max_length' => 'Tên bài hát không quá 255 ký tự',
            'song_name.unique' => 'Tên bài hát đã tồn tại',
            'description.required' => 'Mô tả bài hát không được để trống',
            'description.max_length' => 'Mô tả bài hát không quá 255 ký tự',
            'singer_id.required' => 'Chưa chọn ca sĩ',
            'category_id.required' => 'Chưa chọn thể loại bài hát',
            'release_date.required' => 'Chưa chọn ngày phát hành',
            'country.required' => 'Chưa chọn quốc gia',
            'provider.required' => 'Chưa chọn nhà cung cấp',
            'composer.required' => 'Chưa chọn ca sỹ',
            'file_basic.required' => 'Chưa chọn file bài hát',
            'song_image.required' => 'Chưa chọn ảnh bài hát'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        // Gọi parent để giữ nguyên hành vi mặc định
        parent::failedValidation($validator);

        // Chuyển hướng lại với thông báo lỗi
        throw new \Illuminate\Validation\ValidationException($validator,
            redirect()->back()->withInput()->withErrors($validator->errors()));
    }
}

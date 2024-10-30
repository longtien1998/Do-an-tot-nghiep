<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class MusicUpdateRequest extends FormRequest
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
            'song_name' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'singer_id' => 'required',
            'category_id' => 'required',
            'release_day' => 'required',
            'country_id' => 'required',
            'provider' => 'required|string',
            'composer' => 'required|string',
        ];
    }
    public function messages(): array{
        return [
            'song_name.required' => 'Tên bài hát không được để trống',
            'song_name.max_length' => 'Tên bài hát không quá 255 ký tự',
            'description.required' => 'Mô tả bài hát không được để trống',
            'description.max_length' => 'Mô tả bài hát không quá 255 ký tự',
            'description.string' => 'Mô tả bài hát không phải là chuổi',
            'singer_id.required' => 'Chưa chọn ca sĩ',
            'category_id.required' => 'Chưa chọn thể loại bài hát',
            'country_id.required' => 'Chưa chọn quốc gia',
            'country_id.integer' => 'Chọn quốc gia phải là một số nguyên',
            'provider.string' => 'Chọn nhà cung cấp phải là một chuỗi',
            'release_day.required' => 'Chưa chọn ngày phát hành',
            'provider.required' => 'Chưa chọn nhà cung cấp',
            'composer.required' => 'Chưa chọn nhà soạn nhạc',
        ];
    }
}

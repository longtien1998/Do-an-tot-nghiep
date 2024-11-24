<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
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
        $id = $this->route('id'); // Lấy ID của album nếu đang cập nhật

        return [
            'album_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('albums', 'album_name')->ignore($id, 'id') // Kiểm tra trùng tên album, bỏ qua bản ghi hiện tại khi cập nhật
            ],
            'image' => 'required',
            'singer_id' => [
                'required',
                'integer',
                Rule::exists('singers', 'id') // Kiểm tra nếu singer_id tồn tại trong bảng singers
            ]
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'album_name.required' => 'Tên album không được để trống.',
            'album_name.string' => 'Tên album phải là chuỗi ký tự.',
            'album_name.max' => 'Tên album không được vượt quá 255 ký tự.',
            'album_name.unique' => 'Tên album đã tồn tại.',
            'image.required' => 'Hình ảnh nền không được để trống.',
            'singer_id.required' => 'Ca sĩ không được để trống.',
        ];
    }
}

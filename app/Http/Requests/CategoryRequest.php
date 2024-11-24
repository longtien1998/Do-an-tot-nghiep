<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'categorie_name' => 'required|string|max:255|unique:categories,categorie_name,'. $this->route(param: 'id'),
            'description' => 'required|max:255',
            'background' => 'required'
        ];
    }
    public function messages(): array{
        return [
            'categorie_name.required' => 'Tên thể loại không được để trống.',
            'categorie_name.max' => 'Tên thể loại quá dài.',
            'categorie_name.unique' => 'Tên thể loại đã tồn tại.',
            'description.required' => 'Mô tả không được để trống.',
            'description.max' => 'Mô tả quá dài.',
            'background.required' => 'Hình ảnh nền không được để trống.'
        ];
    }
}

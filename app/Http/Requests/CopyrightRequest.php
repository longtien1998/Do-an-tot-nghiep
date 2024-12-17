<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CopyrightRequest extends FormRequest
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
            'song_id' => 'integer',
            'pulisher_id' => 'integer',
            'license_type' => 'string',
            'issue_day' => 'date',
            'usage_rights' => 'string',
            'price' => 'integer',
            'payment' => 'string',
            'location' => 'string',
            'pay_day' => 'date',
            'terms' => 'string',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'song_id.integer' => 'Song ID không phải là số.',
            'pulisher_id.integer' => 'Publisher ID không phải là số.',
            'license_type.string' => 'Loại giấy phép phải là một chuỗi.',
            'issue_day.date' => 'Ngày phát hành là một ngày thời gian.',
            'usage_rights.string' => 'Quyền sử dụng phải là một chuỗi.',
            'price.integer' => 'Số tiền phải là một số.',
            'payment.string' => 'Hình thức thanh toán phải là một chuỗi.',
            'location.string' => 'Địa điểm phải là một chuỗi.',
            'pay_day.date' => 'Ngày thanh toán phải là một ngày thời gian.',
            'terms.string' => 'Điều khoản phải là một chuỗi.',

        ];
    }
}

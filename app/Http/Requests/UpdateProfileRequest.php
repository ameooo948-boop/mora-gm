<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'gender' => [
                'required',
                Rule::enum(Gender::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'من فضلك أدخل الاسم.',
            'name.string' => 'الاسم غير صحيح.',
            'name.min' => 'الاسم قصير جدًا.',
            'name.max' => 'الاسم طويل جدًا.',

            'phone.string' => 'رقم الهاتف غير صحيح.',
            'phone.max' => 'رقم الهاتف طويل جدًا.',

            'gender.required' => 'من فضلك اختر النوع.',
            'gender.enum' => 'النوع المحدد غير صحيح.',
        ];
    }
}

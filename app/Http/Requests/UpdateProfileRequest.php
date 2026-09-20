<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'phone' => $this->filled('phone')
                ? trim((string) $this->input('phone'))
                : null,
        ]);
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
                'max:30',
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

        ];
    }
}

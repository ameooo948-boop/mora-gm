<?php

namespace App\Http\Requests\Admin;

use App\Enums\Gender;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends AdminFormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'email' => strtolower(trim((string) $this->input('email'))),
            'phone' => $this->filled('phone')
                ? trim((string) $this->input('phone'))
                : null,
        ]);
    }

    public function rules(): array
    {
        $memberId = $this->route('member');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($memberId),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
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
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا صحيحًا.',
            'name.max' => 'الاسم طويل جدًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone.string' => 'رقم الهاتف غير صحيح.',
            'phone.max' => 'رقم الهاتف طويل جدًا.',

            'gender.required' => 'النوع مطلوب.',
            'gender.enum' => 'يرجى اختيار النوع بشكل صحيح.',
        ];
    }
}

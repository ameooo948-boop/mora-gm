<?php

namespace App\Http\Requests\Auth;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'gender' => [
                'required',
                Rule::enum(Gender::class),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم غير صحيح.',
            'name.min' => 'الاسم يجب أن يتكون من حرفين على الأقل.',
            'name.max' => 'الاسم طويل جدًا.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.string' => 'البريد الإلكتروني غير صحيح.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.max' => 'البريد الإلكتروني طويل جدًا.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'gender.required' => 'من فضلك اختر النوع.',
            'gender.enum' => 'النوع المحدد غير صحيح.',
            'phone.string' => 'رقم الهاتف غير صحيح.',
            'phone.max' => 'رقم الهاتف طويل جدًا.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'كلمة المرور غير صحيحة.',
            'password.min' => 'كلمة المرور يجب أن تتكون من 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ];
    }
}

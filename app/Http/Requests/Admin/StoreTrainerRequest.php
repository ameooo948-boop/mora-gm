<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:trainers,slug',
            ],

            'gender' => [
                'required',
                Rule::in(['male', 'female']),
            ],

            'specialization' => [
                'required',
                'string',
                'max:255',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:999',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المدرب مطلوب.',
            'name.max' => 'اسم المدرب يجب ألا يتجاوز 255 حرفًا.',

            'slug.required' => 'المعرّف مطلوب.',
            'slug.unique' => 'هذا المعرّف مستخدم بالفعل.',

            'gender.required' => 'نوع المدرب مطلوب.',
            'gender.in' => 'نوع المدرب غير صحيح.',

            'specialization.required' => 'التخصص مطلوب.',
            'specialization.max' => 'التخصص يجب ألا يتجاوز 255 حرفًا.',

            'bio.max' => 'النبذة يجب ألا تتجاوز 2000 حرف.',

            'image.max' => 'مسار الصورة طويل جدًا.',

            'is_active.boolean' => 'حالة المدرب غير صحيحة.',

            'sort_order.integer' => 'ترتيب المدرب يجب أن يكون رقمًا صحيحًا.',
            'sort_order.min' => 'ترتيب المدرب لا يمكن أن يكون أقل من صفر.',
            'sort_order.max' => 'ترتيب المدرب لا يمكن أن يتجاوز 999.',
        ];
    }
}

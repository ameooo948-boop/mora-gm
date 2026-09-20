<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipPlanRequest extends FormRequest
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
                'unique:membership_plans,slug',
            ],

            'duration_days' => [
                'required',
                'integer',
                'min:1',
                'max:3650',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*' => [
                'nullable',
                'string',
                'max:255',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
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
            'name.required' => 'اسم الباقة مطلوب.',
            'name.max' => 'اسم الباقة يجب ألا يتجاوز 255 حرفًا.',

            'slug.required' => 'المعرّف مطلوب.',
            'slug.unique' => 'هذا المعرّف مستخدم بالفعل.',

            'duration_days.required' => 'مدة الباقة مطلوبة.',
            'duration_days.integer' => 'مدة الباقة يجب أن تكون رقمًا صحيحًا.',
            'duration_days.min' => 'مدة الباقة يجب أن تكون يومًا واحدًا على الأقل.',

            'price.required' => 'سعر الباقة مطلوب.',
            'price.numeric' => 'سعر الباقة يجب أن يكون رقمًا.',
            'price.min' => 'سعر الباقة لا يمكن أن يكون سالبًا.',

            'short_description.max' => 'الوصف المختصر يجب ألا يتجاوز 255 حرفًا.',
            'description.max' => 'الوصف يجب ألا يتجاوز 5000 حرف.',

            'features.array' => 'مميزات الباقة غير صحيحة.',
            'features.*.string' => 'كل ميزة يجب أن تكون نصًا.',
            'features.*.max' => 'الميزة يجب ألا تتجاوز 255 حرفًا.',

            'is_featured.boolean' => 'حالة الباقة المميزة غير صحيحة.',
            'is_active.boolean' => 'حالة الباقة غير صحيحة.',

            'sort_order.integer' => 'ترتيب الباقة يجب أن يكون رقمًا صحيحًا.',
            'sort_order.min' => 'ترتيب الباقة لا يمكن أن يكون أقل من صفر.',
        ];
    }
}

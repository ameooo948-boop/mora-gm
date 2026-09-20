<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateMembershipPlanRequest extends AdminFormRequest
{


    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'slug' => strtolower(trim((string) $this->input('slug'))),
            'short_description' => $this->filled('short_description')
                ? trim((string) $this->input('short_description'))
                : null,
            'description' => $this->filled('description')
                ? trim((string) $this->input('description'))
                : null,
        ]);
    }

    public function rules(): array
    {

        $membershipPlan = $this->route('membership_plan');

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
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('membership_plans', 'slug')
                    ->ignore($membershipPlan->id),
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

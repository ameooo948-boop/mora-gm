<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateTrainerRequest extends AdminFormRequest
{


    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'slug' => strtolower(trim((string) $this->input('slug'))),
            'specialization' => trim((string) $this->input('specialization')),
            'bio' => $this->filled('bio')
                ? trim((string) $this->input('bio'))
                : null,
            'image' => $this->filled('image')
                ? trim((string) $this->input('image'))
                : null,
        ]);
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
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('trainers', 'slug')->ignore($this->route('trainer')),
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

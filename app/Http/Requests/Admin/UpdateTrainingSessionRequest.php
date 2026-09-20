<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'audience' => [
                'required',
                'in:Men,Women',
            ],

            'trainer_id' => [
                'required',
                'integer',
                'exists:trainers,id',
            ],

            'starts_at' => [
                'required',
                'date_format:H:i',
            ],

            'ends_at' => [
                'required',
                'date_format:H:i',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
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
            'name.required' => 'اسم الجلسة مطلوب.',
            'name.max' => 'اسم الجلسة طويل جدًا.',

            'audience.required' => 'نوع الجلسة مطلوب.',
            'audience.in' => 'نوع الجلسة غير صحيح.',

            'trainer_id.required' => 'يجب اختيار المدرب.',
            'trainer_id.integer' => 'المدرب المحدد غير صحيح.',
            'trainer_id.exists' => 'المدرب المحدد غير موجود.',

            'starts_at.required' => 'وقت بداية الجلسة مطلوب.',
            'starts_at.date_format' => 'وقت البداية يجب أن يكون بصيغة صحيحة.',

            'ends_at.required' => 'وقت نهاية الجلسة مطلوب.',
            'ends_at.date_format' => 'وقت النهاية يجب أن يكون بصيغة صحيحة.',

            'description.string' => 'وصف الجلسة غير صحيح.',
            'description.max' => 'وصف الجلسة طويل جدًا.',

            'is_active.boolean' => 'حالة الجلسة غير صحيحة.',

            'sort_order.integer' => 'ترتيب الجلسة يجب أن يكون رقمًا صحيحًا.',
            'sort_order.min' => 'ترتيب الجلسة لا يمكن أن يكون أقل من صفر.',
        ];
    }
}

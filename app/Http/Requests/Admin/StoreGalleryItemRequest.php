<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'image' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الصورة مطلوب.',
            'title.string' => 'عنوان الصورة يجب أن يكون نصًا.',
            'title.max' => 'عنوان الصورة يجب ألا يتجاوز 255 حرفًا.',

            'category.required' => 'التصنيف مطلوب.',
            'category.string' => 'التصنيف يجب أن يكون نصًا.',
            'category.max' => 'التصنيف يجب ألا يتجاوز 100 حرف.',

            'image.required' => 'مسار الصورة مطلوب.',
            'image.string' => 'مسار الصورة يجب أن يكون نصًا.',
            'image.max' => 'مسار الصورة يجب ألا يتجاوز 500 حرف.',

            'description.string' => 'الوصف يجب أن يكون نصًا.',
            'description.max' => 'الوصف يجب ألا يتجاوز 2000 حرف.',

            'is_active.boolean' => 'حالة الصورة غير صحيحة.',

            'sort_order.integer' => 'ترتيب الصورة يجب أن يكون رقمًا صحيحًا.',
            'sort_order.min' => 'ترتيب الصورة لا يمكن أن يكون أقل من صفر.',
            'sort_order.max' => 'ترتيب الصورة يجب ألا يتجاوز 999.',
        ];
    }
}

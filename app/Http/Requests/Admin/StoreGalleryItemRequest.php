<?php

namespace App\Http\Requests\Admin;

class StoreGalleryItemRequest extends AdminFormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim((string) $this->input('title')),
            'category' => trim((string) $this->input('category')),
            'image' => trim((string) $this->input('image')),
            'description' => $this->filled('description')
                ? trim((string) $this->input('description'))
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
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

            'image.required' => 'الصورة مطلوبة.',
            'image.image' => 'الملف المحدد يجب أن يكون صورة.',
            'image.mimes' => 'صيغة الصورة يجب أن تكون JPG أو JPEG أو PNG أو WEBP.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.',
            
            'description.string' => 'الوصف يجب أن يكون نصًا.',
            'description.max' => 'الوصف يجب ألا يتجاوز 2000 حرف.',

            'image.regex' => 'مسار الصورة غير صالح.',

            'is_active.boolean' => 'حالة الصورة غير صحيحة.',

            'sort_order.integer' => 'ترتيب الصورة يجب أن يكون رقمًا صحيحًا.',
            'sort_order.min' => 'ترتيب الصورة لا يمكن أن يكون أقل من صفر.',
            'sort_order.max' => 'ترتيب الصورة يجب ألا يتجاوز 999.',
        ];
    }
}

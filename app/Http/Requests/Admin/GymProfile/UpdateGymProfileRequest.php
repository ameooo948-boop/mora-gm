<?php

namespace App\Http\Requests\Admin\GymProfile;

use App\Http\Requests\Admin\AdminFormRequest;

class UpdateGymProfileRequest extends AdminFormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'eyebrow' => ['nullable', 'string', 'max:255'],

            'about_title' => ['required', 'string', 'max:255'],
            'about_description' => ['required', 'string', 'max:5000'],

            'mission_title' => ['required', 'string', 'max:255'],
            'mission' => ['required', 'string', 'max:5000'],

            'vision_title' => ['required', 'string', 'max:255'],
            'vision' => ['required', 'string', 'max:5000'],

            'image' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^(?!\/)(?!.*\.\.)[A-Za-z0-9_\/.\-]+$/',
            ],

            'space_size' => ['required', 'integer', 'min:1', 'max:100000'],
            'trainer_count' => ['required', 'integer', 'min:0', 'max:1000'],

            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'vodafone_cash' => ['nullable', 'string', 'max:30'],

            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الجيم مطلوب.',
            'about_title.required' => 'عنوان نبذة الجيم مطلوب.',
            'about_description.required' => 'وصف الجيم مطلوب.',
            'mission_title.required' => 'عنوان الرسالة مطلوب.',
            'mission.required' => 'الرسالة مطلوبة.',
            'vision_title.required' => 'عنوان الرؤية مطلوب.',
            'vision.required' => 'الرؤية مطلوبة.',

            'space_size.required' => 'مساحة الجيم مطلوبة.',
            'space_size.integer' => 'مساحة الجيم يجب أن تكون رقمًا صحيحًا.',
            'space_size.min' => 'مساحة الجيم يجب أن تكون أكبر من صفر.',

            'trainer_count.required' => 'عدد المدربين مطلوب.',
            'trainer_count.integer' => 'عدد المدربين يجب أن يكون رقمًا صحيحًا.',
            'trainer_count.min' => 'عدد المدربين لا يمكن أن يكون رقمًا سالبًا.',

            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'instagram_url.url' => 'رابط إنستجرام غير صحيح.',
            'image.regex' => 'مسار الصورة غير صالح.',

        ];
    }
}

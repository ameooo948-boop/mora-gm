<?php

namespace App\Http\Requests\Admin;

class RejectPaymentRequest extends AdminFormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'notes' => $this->filled('notes')
                ? trim((string) $this->input('notes'))
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'notes.string' => 'ملاحظات الرفض غير صحيحة.',
            'notes.max' => 'ملاحظات الرفض طويلة جدًا.',
        ];
    }
}

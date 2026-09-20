<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitVodafoneCashPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'transaction_reference' => trim((string) $this->input('transaction_reference')),
            'paid_at' => trim((string) $this->input('paid_at')),
        ]);
    }

    public function rules(): array
    {
        return [
            'transaction_reference' => [
                'required',
                'string',
                'min:4',
                'max:100',
            ],

            'paid_at' => [
                'required',
                'date',
                'before_or_equal:now',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'transaction_reference.required' => 'من فضلك أدخل رقم العملية.',

            'transaction_reference.min' => 'رقم العملية غير صحيح.',

            'transaction_reference.max' => 'رقم العملية طويل جدًا.',

            'paid_at.required' => 'من فضلك أدخل تاريخ ووقت التحويل.',

            'paid_at.date' => 'تاريخ ووقت التحويل غير صحيح.',

            'paid_at.before_or_equal' => 'لا يمكن أن يكون وقت التحويل في المستقبل.',
        ];
    }
}

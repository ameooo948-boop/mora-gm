<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index(): View
    {
        return view('admin.payments.index', [
            'payments' => $this->paymentService
                ->getPendingPayments(),
        ]);
    }

    public function approve(
        int $payment
    ): RedirectResponse {
        $this->paymentService
            ->approvePayment($payment);

        return back()->with(
            'success',
            'تم تأكيد الدفع وتفعيل العضوية بنجاح.'
        );
    }

    public function reject(
        Request $request,
        int $payment
    ): RedirectResponse {
        $validated = $request->validate([
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'notes.string' => 'ملاحظات الرفض غير صحيحة.',

            'notes.max' => 'ملاحظات الرفض طويلة جدًا.',
        ]);

        $this->paymentService->rejectPayment(
            $payment,
            $validated['notes'] ?? null
        );

        return back()->with(
            'success',
            'تم رفض عملية الدفع.'
        );
    }
}

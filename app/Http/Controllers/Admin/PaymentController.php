<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectPaymentRequest;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
        RejectPaymentRequest $request,
        int $payment
    ): RedirectResponse {
        $this->paymentService->rejectPayment(
            $payment,
            $request->validated('notes')
        );

        return back()->with(
            'success',
            'تم رفض عملية الدفع.'
        );
    }
}

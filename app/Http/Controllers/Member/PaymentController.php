<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitVodafoneCashPaymentRequest;
use App\Services\GymProfileService;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected GymProfileService $gymProfileService
    ) {}

    public function show(
        Request $request,
        int $payment
    ): View {
        $selectedPayment = $this->paymentService
            ->getPaymentForUser(
                $payment,
                $request->user()->id
            );

        abort_unless($selectedPayment, 404);

        return view('member.payment', [
            'payment' => $selectedPayment,
            'gymProfile' => $this->gymProfileService->getActiveProfile(),
        ]);
    }

    public function submit(
        SubmitVodafoneCashPaymentRequest $request,
        int $payment
    ): RedirectResponse {
        $this->paymentService->submitVodafoneCashPayment(
            paymentId: $payment,
            userId: $request->user()->id,
            transactionReference: $request->validated('transaction_reference'),
            paidAt: $request->validated('paid_at'),
        );

        return redirect()
            ->route('member.subscription')
            ->with(
                'success',
                'تم إرسال بيانات التحويل بنجاح، وسيتم مراجعتها من إدارة MORA.'
            );
    }
}

<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {}

    public function subscribe(
        Request $request,
        MembershipPlan $membershipPlan
    ): RedirectResponse {
        $user = $request->user();

        $activeSubscription = $this->subscriptionService
            ->getActiveSubscription($user->id);

        if ($activeSubscription) {
            return redirect()
                ->route('member.subscription')
                ->with(
                    'error',
                    'لديك عضوية فعالة بالفعل ولا يمكنك إنشاء اشتراك جديد حاليًا.'
                );
        }

        $pendingSubscription = $this->subscriptionService
            ->getPendingSubscription($user->id);

        if ($pendingSubscription) {
            return redirect()
                ->route(
                    'member.payment.show',
                    $pendingSubscription->payment->id
                )
                ->with(
                    'info',
                    'لديك طلب اشتراك قيد الانتظار بالفعل.'
                );
        }

        $subscription = $this->subscriptionService
            ->createSubscription(
                $user->id,
                $membershipPlan
            );

        return redirect()
            ->route(
                'member.payment.show',
                $subscription->payment->id
            )
            ->with(
                'success',
                'تم إنشاء طلب الاشتراك. أكمل عملية الدفع لإرسال الطلب للمراجعة.'
            );
    }
}

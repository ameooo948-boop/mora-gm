<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('member.subscription', [
            'activeSubscription' => $this->subscriptionService
                ->getActiveSubscription($user->id),

            'subscriptions' => $this->subscriptionService
                ->getUserSubscriptions($user->id),
        ]);
    }
}

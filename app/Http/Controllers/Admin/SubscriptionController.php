<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();
        $status = $request->string('status')->trim()->value();

        $allowedStatuses = [
            'active',
            'pending',
            'expired',
            'cancelled',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = null;
        }

        return view('admin.subscriptions.index', [
            'subscriptions' => $this->subscriptionService
                ->getAllSubscriptions(
                    status: $status,
                    search: $search ?: null,
                ),

            'search' => $search,
            'status' => $status,
        ]);
    }

    public function show(int $subscription): View
    {
        $selectedSubscription = $this->subscriptionService
            ->getSubscription($subscription);

        abort_unless($selectedSubscription, 404);

        return view('admin.subscriptions.show', [
            'subscription' => $selectedSubscription,
        ]);
    }
}

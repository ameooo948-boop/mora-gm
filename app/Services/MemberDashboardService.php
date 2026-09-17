<?php

namespace App\Services;

use App\Models\User;

class MemberDashboardService
{
    public function __construct(
        protected SubscriptionService $subscriptionService,
        protected AttendanceService $attendanceService,
        protected PaymentService $paymentService,
    ) {}

    public function getDashboardData(User $user): array
    {
        return [
            'activeSubscription' => $this->subscriptionService
                ->getActiveSubscription($user->id),

            'recentAttendances' => $this->attendanceService
                ->getUserAttendances($user->id, 5),

            'recentPayments' => $this->paymentService
                ->getUserPayments($user->id, 5),
        ];
    }
}

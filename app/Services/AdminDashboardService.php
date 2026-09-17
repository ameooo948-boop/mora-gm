<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

class AdminDashboardService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected SubscriptionService $subscriptionService,
        protected PaymentService $paymentService,
        protected AttendanceService $attendanceService,
    ) {}

    public function getDashboardData(): array
    {
        return [
            'membersCount' => $this->userRepository->countMembers(),

            'activeMembersCount' => $this->userRepository->countActiveMembers(),

            'activeSubscriptionsCount' => $this->subscriptionService->countActiveSubscriptions(),

            'pendingPaymentsCount' => $this->paymentService->countPendingPayments(),

            'todayAttendanceCount' => $this->attendanceService->countToday(),
        ];
    }
}

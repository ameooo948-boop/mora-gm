<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionService
{
    public function __construct(
        protected SubscriptionRepositoryInterface $repository,
        protected MembershipPlanRepositoryInterface $membershipPlanRepository,
        protected PaymentRepositoryInterface $paymentRepository,
        protected UserRepositoryInterface $userRepository,
        protected NotificationService $notificationService,
    ) {}

    public function getActiveSubscription(
        int $userId
    ): ?Subscription {
        return $this->repository->findActiveByUser($userId);
    }

    public function getUserSubscriptions(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getByUser(
            $userId,
            $perPage
        );
    }

    public function createSubscription(
        int $userId,
        MembershipPlan $plan
    ): Subscription {
        $subscription = DB::transaction(function () use (
            $userId,
            $plan
        ) {
            $user = $this->userRepository->findByIdForUpdate($userId);

            if (! $user) {
                throw ValidationException::withMessages([
                    'subscription' => 'الحساب المطلوب غير موجود.',
                ]);
            }

            $plan = $this->membershipPlanRepository->findByIdForUpdate($plan->id);

            if (! $plan) {
                throw ValidationException::withMessages([
                    'subscription' => 'الباقة المطلوبة غير موجودة.',
                ]);
            }

            if (! $plan->is_active || $plan->price === null) {
                throw ValidationException::withMessages([
                    'subscription' => 'هذه الباقة غير متاحة للاشتراك حاليًا.',
                ]);
            }

            if ($plan->duration_days < 1) {
                throw ValidationException::withMessages([
                    'subscription' => 'مدة الباقة غير صالحة للاشتراك.',
                ]);
            }

            if ($this->repository->findActiveByUser($userId)) {
                throw ValidationException::withMessages([
                    'subscription' => 'لديك عضوية فعالة بالفعل.',
                ]);
            }

            if ($this->repository->findPendingByUser($userId)) {
                throw ValidationException::withMessages([
                    'subscription' => 'لديك طلب اشتراك قيد الانتظار بالفعل.',
                ]);
            }

            $subscription = $this->repository->create([
                'user_id' => $userId,
                'membership_plan_id' => $plan->id,
                'price' => $plan->price,
                'duration_days' => $plan->duration_days,
                'starts_at' => null,
                'ends_at' => null,
                'status' => SubscriptionStatus::PENDING,
            ]);

            $this->paymentRepository->create([
                'user_id' => $userId,
                'subscription_id' => $subscription->id,
                'amount' => $plan->price,
                'method' => 'vodafone_cash',
                'status' => PaymentStatus::PENDING,
            ]);

            return $subscription->load([
                'membershipPlan',
                'payment',
            ]);
        });

        $this->notificationService->create(
            userId: $userId,
            title: 'تم إنشاء طلب الاشتراك',
            message: "تم إنشاء طلب اشتراكك في باقة {$subscription->membershipPlan->name}. برجاء إتمام الدفع عبر فودافون كاش.",
            type: 'subscription',
            actionUrl: $subscription->payment
                ? route(
                    'member.payment.show',
                    $subscription->payment->id
                )
                : route('member.subscription'),
        );

        return $subscription;
    }

    public function getPendingSubscription(
        int $userId
    ): ?Subscription {
        return $this->repository->findPendingByUser($userId);
    }

    public function hasActiveSubscription(int $userId): bool
    {
        return $this->repository->hasActiveByUser($userId);
    }

    public function countActiveSubscriptions(): int
    {
        return $this->repository->countActive();
    }

    public function getAllSubscriptions(
        ?string $status = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll(
            $status,
            $search,
            $perPage
        );
    }

    public function getSubscription(int $id): ?Subscription
    {
        return $this->repository->findById($id);
    }
}

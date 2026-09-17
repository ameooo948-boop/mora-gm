<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionService
{
    public function __construct(
        protected SubscriptionRepositoryInterface $repository
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

        return DB::transaction(function () use ($userId, $plan) {

            $subscription = $this->repository->create([
                'user_id' => $userId,
                'membership_plan_id' => $plan->id,
                'price' => $plan->price,
                'starts_at' => null,
                'ends_at' => null,
                'status' => SubscriptionStatus::PENDING,
            ]);

            Payment::create([
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

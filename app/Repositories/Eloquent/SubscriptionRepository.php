<?php

namespace App\Repositories\Eloquent;

use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function __construct(
        protected Subscription $model
    ) {}

    public function findActiveByUser(int $userId): ?Subscription
    {
        return $this->model
            ->newQuery()
            ->with('membershipPlan')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();
    }

    public function getByUser(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with('membershipPlan')
            ->where('user_id', $userId)
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function create(array $data): Subscription
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        Subscription $subscription,
        array $data
    ): Subscription {
        $subscription->update($data);

        return $subscription->fresh('membershipPlan');
    }

    public function findPendingByUser(int $userId): ?Subscription
    {
        return $this->model
            ->newQuery()
            ->with([
                'membershipPlan',
                'payment',
            ])
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->whereHas('payment', function ($query) {
                $query->where('status', 'pending');
            })
            ->latest()
            ->first();
    }

    public function hasActiveByUser(int $userId): bool
    {
        return $this->model
            ->newQuery()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->exists();
    }
}

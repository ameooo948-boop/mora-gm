<?php

namespace App\Repositories\Eloquent;

use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    public function countActive(): int
    {
        return $this->model
            ->newQuery()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->count();
    }

    public function getAll(
        ?string $status = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with([
                'user',
                'membershipPlan',
                'payment',
            ])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id): ?Subscription
    {
        return $this->model
            ->newQuery()
            ->with([
                'user',
                'membershipPlan',
                'payment',
            ])
            ->find($id);
    }

    public function findByIdForUpdate(int $id): ?Subscription
    {
        return $this->model
            ->newQuery()
            ->whereKey($id)
            ->with([
                'user',
                'membershipPlan',
                'payment',
            ])
            ->lockForUpdate()
            ->first();
    }

    public function getExpiringSubscriptions(): Collection
    {
        return $this->model
            ->newQuery()
            ->with('membershipPlan')
            ->where('status', 'active')
            ->whereNotNull('ends_at')
            ->where('ends_at', '>', now())
            ->where(
                'ends_at',
                '<=',
                now()->addDays(3)
            )
            ->get();
    }

    public function getExpiredSubscriptions(): Collection
    {
        return $this->model
            ->newQuery()
            ->with('membershipPlan')
            ->where('status', 'active')
            ->whereNotNull('ends_at')
            ->where('ends_at', '<=', now())
            ->get();
    }
}

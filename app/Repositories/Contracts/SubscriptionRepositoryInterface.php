<?php

namespace App\Repositories\Contracts;

use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SubscriptionRepositoryInterface
{
    public function findActiveByUser(int $userId): ?Subscription;

    public function getByUser(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function create(array $data): Subscription;

    public function update(
        Subscription $subscription,
        array $data
    ): Subscription;

    public function findPendingByUser(int $userId): ?Subscription;

    public function hasActiveByUser(int $userId): bool;
}

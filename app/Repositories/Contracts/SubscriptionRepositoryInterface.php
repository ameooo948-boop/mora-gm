<?php

namespace App\Repositories\Contracts;

use App\Models\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    public function countActive(): int;

    public function getAll(
        ?string $status = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int $id): ?Subscription;

    public function findByIdForUpdate(int $id): ?Subscription;

    public function getExpiringSubscriptions(): Collection;

    public function getExpiredSubscriptions(): Collection;
}

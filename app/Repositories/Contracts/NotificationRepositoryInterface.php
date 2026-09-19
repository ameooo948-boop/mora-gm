<?php

namespace App\Repositories\Contracts;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface
{
    public function create(array $data): Notification;

    public function findById(int $id): ?Notification;

    public function findByIdForUser(int $id, int $userId): ?Notification;

    public function getByUser(
        int $userId,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getUnreadByUser(int $userId): Collection;

    public function countUnreadByUser(int $userId): int;

    public function markAsRead(Notification $notification): Notification;

    public function markAllAsRead(int $userId): int;
}

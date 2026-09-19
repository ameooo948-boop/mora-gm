<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    public function findById(int $id): ?Notification
    {
        return Notification::query()
            ->with('user')
            ->find($id);
    }

    public function findByIdForUser(
        int $id,
        int $userId
    ): ?Notification {
        return Notification::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function getByUser(
        int $userId,
        int $perPage = 15
    ): LengthAwarePaginator {
        return Notification::query()
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getUnreadByUser(int $userId): Collection
    {
        return Notification::query()
            ->where('user_id', $userId)
            ->unread()
            ->latest()
            ->get();
    }

    public function countUnreadByUser(int $userId): int
    {
        return Notification::query()
            ->where('user_id', $userId)
            ->unread()
            ->count();
    }

    public function markAsRead(Notification $notification): Notification
    {
        $notification->markAsRead();

        return $notification->fresh();
    }

    public function markAllAsRead(int $userId): int
    {
        return Notification::query()
            ->where('user_id', $userId)
            ->unread()
            ->update([
                'read_at' => now(),
            ]);
    }
}

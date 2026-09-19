<?php

namespace App\Services;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    public function __construct(
        protected NotificationRepositoryInterface $repository
    ) {}

    public function create(
        int $userId,
        string $title,
        string $message,
        string $type = 'info',
        ?string $actionUrl = null
    ): Notification {
        return $this->repository->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);
    }

    public function getUserNotifications(
        int $userId,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getByUser(
            $userId,
            $perPage
        );
    }

    public function getUnreadNotifications(
        int $userId
    ): Collection {
        return $this->repository->getUnreadByUser($userId);
    }

    public function countUnread(int $userId): int
    {
        return $this->repository->countUnreadByUser($userId);
    }

    public function markAsRead(
        Notification $notification
    ): Notification {
        return $this->repository->markAsRead($notification);
    }

    public function markAsReadForUser(
        int $notificationId,
        int $userId
    ): ?Notification {
        $notification = $this->repository->findByIdForUser(
            $notificationId,
            $userId
        );

        if (! $notification) {
            return null;
        }

        return $this->repository->markAsRead($notification);
    }

    public function markAllAsRead(int $userId): int
    {
        return $this->repository->markAllAsRead($userId);
    }
}

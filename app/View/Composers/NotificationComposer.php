<?php

namespace App\View\Composers;

use App\Services\NotificationService;
use Illuminate\View\View;

class NotificationComposer
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function compose(View $view): void
    {
        $user = auth()->user();

        $unreadNotificationsCount = 0;

        if ($user) {
            $unreadNotificationsCount =
                $this->notificationService->countUnread($user->id);
        }

        $view->with(
            'unreadNotificationsCount',
            $unreadNotificationsCount
        );
    }
}

<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function index(Request $request): View
    {
        $notifications = $this->notificationService->getUserNotifications(
            $request->user()->id
        );

        return view('member.notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(
        Request $request,
        int $notification
    ): RedirectResponse {
        $result = $this->notificationService->markAsReadForUser(
            $notification,
            $request->user()->id
        );

        if (! $result) {
            abort(404);
        }

        return back()->with(
            'success',
            'تم تحديد الإشعار كمقروء.'
        );
    }

    public function markAllAsRead(
        Request $request
    ): RedirectResponse {
        $this->notificationService->markAllAsRead(
            $request->user()->id
        );

        return back()->with(
            'success',
            'تم تحديد جميع الإشعارات كمقروءة.'
        );
    }
}

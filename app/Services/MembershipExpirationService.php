<?php

namespace App\Services;

use App\Enums\SubscriptionStatus;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;

class MembershipExpirationService
{
    public function __construct(
        protected SubscriptionRepositoryInterface $subscriptionRepository,
        protected NotificationService $notificationService,
    ) {}

    public function notifyExpiringSubscriptions(): int
    {
        $subscriptions = $this->subscriptionRepository
            ->getExpiringSubscriptions();

        $count = 0;

        foreach ($subscriptions as $subscription) {
            $daysRemaining = now()->startOfDay()->diffInDays(
                $subscription->ends_at->startOfDay()
            );

            $title = 'عضويتك قاربت على الانتهاء';

            if (
                $this->notificationService->existsRecentForUser(
                    $subscription->user_id,
                    $title,
                    1
                )
            ) {
                continue;
            }

            $this->notificationService->create(
                userId: $subscription->user_id,
                title: $title,
                message: "متبقي {$daysRemaining} يوم على انتهاء عضويتك في باقة {$subscription->membershipPlan->name}.",
                type: 'subscription',
                actionUrl: route('member.subscription'),
            );

            $count++;
        }

        return $count;
    }

    public function notifyExpiredSubscriptions(): int
    {
        $subscriptions = $this->subscriptionRepository
            ->getExpiredSubscriptions();

        $count = 0;

        foreach ($subscriptions as $subscription) {
            $title = 'انتهت عضويتك';

            if (
                $this->notificationService->existsRecentForUser(
                    $subscription->user_id,
                    $title,
                    1
                )
            ) {
                continue;
            }

            $this->notificationService->create(
                userId: $subscription->user_id,
                title: $title,
                message: "انتهت عضويتك في باقة {$subscription->membershipPlan->name}. يمكنك اختيار باقة جديدة للاستمرار في التدريب.",
                type: 'subscription',
                actionUrl: route('home').'#memberships',
            );

            $this->subscriptionRepository->update(
                $subscription,
                [
                    'status' => SubscriptionStatus::EXPIRED,
                ]
            );

            $count++;
        }

        return $count;
    }
}

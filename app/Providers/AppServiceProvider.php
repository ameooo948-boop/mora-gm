<?php

namespace App\Providers;

use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use App\Repositories\Contracts\GymProfileRepositoryInterface;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Repositories\Contracts\TrainerRepositoryInterface;
use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface as ContractsUserRepositoryInterface;
use App\Repositories\Eloquent\AttendanceRepository;
use App\Repositories\Eloquent\GalleryItemRepository;
use App\Repositories\Eloquent\GymProfileRepository;
use App\Repositories\Eloquent\MembershipPlanRepository;
use App\Repositories\Eloquent\NotificationRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\SubscriptionRepository;
use App\Repositories\Eloquent\TrainerRepository;
use App\Repositories\Eloquent\TrainingSessionRepository;
use App\Repositories\Eloquent\UserRepository;
use App\View\Composers\NotificationComposer;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TrainingSessionRepositoryInterface::class,
            TrainingSessionRepository::class
        );

        $this->app->bind(
            GymProfileRepositoryInterface::class,
            GymProfileRepository::class
        );

        $this->app->bind(
            MembershipPlanRepositoryInterface::class,
            MembershipPlanRepository::class
        );

        $this->app->bind(
            TrainerRepositoryInterface::class,
            TrainerRepository::class
        );

        $this->app->bind(
            GalleryItemRepositoryInterface::class,
            GalleryItemRepository::class
        );

        $this->app->bind(
            ContractsUserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );

        $this->app->bind(
            AttendanceRepositoryInterface::class,
            AttendanceRepository::class
        );

        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
    }

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, string $url): MailMessage {
            return (new MailMessage)
                ->subject('تأكيد بريدك الإلكتروني - MORA GYM')
                ->greeting('مرحبًا بك في MORA GYM')
                ->line('يرجى تأكيد بريدك الإلكتروني لتفعيل حسابك.')
                ->action('تأكيد البريد الإلكتروني', $url)
                ->line('إذا لم تنشئ حسابًا في MORA GYM، يمكنك تجاهل هذه الرسالة.');
        });

        ResetPassword::toMailUsing(function ($notifiable, string $token): MailMessage {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('إعادة تعيين كلمة المرور - MORA GYM')
                ->greeting('مرحبًا بك في MORA GYM')
                ->line('تلقينا طلبًا لإعادة تعيين كلمة المرور الخاصة بحسابك.')
                ->action('إعادة تعيين كلمة المرور', $url)
                ->line('هذا الرابط صالح لمدة محدودة. إذا لم تطلب إعادة التعيين، يمكنك تجاهل هذه الرسالة.');
        });

        View::composer(
            'components.navbar',
            NotificationComposer::class
        );
    }
}

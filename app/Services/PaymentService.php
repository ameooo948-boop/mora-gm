<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function __construct(
        protected PaymentRepositoryInterface $repository,
        protected SubscriptionRepositoryInterface $subscriptionRepository,
        protected NotificationService $notificationService,
    ) {}

    public function getUserPayments(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getByUser(
            $userId,
            $perPage
        );
    }

    public function submitVodafoneCashPayment(
        int $paymentId,
        int $userId,
        string $transactionReference,
        string $paidAt
    ): Payment {
        $transactionReference = trim($transactionReference);

        $payment = DB::transaction(function () use (
            $paymentId,
            $userId,
            $transactionReference,
            $paidAt
        ) {
            $payment = $this->repository->findByIdForUserForUpdate(
                $paymentId,
                $userId
            );

            if (! $payment) {
                throw ValidationException::withMessages([
                    'payment' => 'عملية الدفع غير موجودة.',
                ]);
            }

            if ($payment->method !== 'vodafone_cash') {
                throw ValidationException::withMessages([
                    'payment' => 'طريقة الدفع الحالية غير مدعومة.',
                ]);
            }

            if ($payment->status !== PaymentStatus::PENDING) {
                throw ValidationException::withMessages([
                    'payment' => 'لا يمكن تعديل عملية الدفع الحالية.',
                ]);
            }

            if (! $payment->subscription) {
                throw ValidationException::withMessages([
                    'payment' => 'الاشتراك المرتبط بعملية الدفع غير موجود.',
                ]);
            }

            if (
                $payment->subscription->status
                !== SubscriptionStatus::PENDING
            ) {
                throw ValidationException::withMessages([
                    'payment' => 'حالة الاشتراك لا تسمح بإرسال عملية دفع جديدة.',
                ]);
            }

            return $this->repository->update(
                $payment,
                [
                    'transaction_reference' => $transactionReference,
                    'paid_at' => $paidAt,
                    'status' => PaymentStatus::PENDING,
                ]
            );
        });

        $this->notificationService->create(
            userId: $userId,
            title: 'تم إرسال بيانات الدفع',
            message: 'تم إرسال رقم عملية فودافون كاش بنجاح، وسيتم مراجعة عملية الدفع من الإدارة.',
            type: 'payment',
            actionUrl: route('member.payment.show', $payment->id),
        );

        return $payment;
    }

    public function getPaymentForUser(
        int $paymentId,
        int $userId
    ): ?Payment {
        return $this->repository->findByIdForUser(
            $paymentId,
            $userId
        );
    }

    public function getPendingPayments(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getPending($perPage);
    }

    public function getAllPayments(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll($perPage);
    }

    public function approvePayment(
        int $paymentId
    ): Payment {
        $payment = DB::transaction(function () use ($paymentId) {
            $payment = $this->repository->findByIdForUpdate($paymentId);

            if (! $payment) {
                throw ValidationException::withMessages([
                    'payment' => 'عملية الدفع غير موجودة.',
                ]);
            }

            if ($payment->status !== PaymentStatus::PENDING) {
                throw ValidationException::withMessages([
                    'payment' => 'عملية الدفع تمت مراجعتها بالفعل.',
                ]);
            }

            if ($payment->method !== 'vodafone_cash') {
                throw ValidationException::withMessages([
                    'payment' => 'طريقة الدفع الحالية غير مدعومة للتأكيد.',
                ]);
            }

            if (! $payment->transaction_reference) {
                throw ValidationException::withMessages([
                    'payment' => 'لا يمكن تأكيد عملية دفع لم يتم إرسال رقم العملية الخاص بها.',
                ]);
            }

            if (! $payment->subscription) {
                throw ValidationException::withMessages([
                    'payment' => 'الاشتراك المرتبط بعملية الدفع غير موجود.',
                ]);
            }

            $subscription = $this->subscriptionRepository->findByIdForUpdate(
                $payment->subscription->id
            );

            if (! $subscription) {
                throw ValidationException::withMessages([
                    'payment' => 'الاشتراك المرتبط بعملية الدفع غير موجود.',
                ]);
            }

            if ((float) $payment->amount !== (float) $subscription->price) {
                throw ValidationException::withMessages([
                    'payment' => 'قيمة عملية الدفع لا تطابق قيمة الاشتراك.',
                ]);
            }

            if ($subscription->status !== SubscriptionStatus::PENDING) {
                throw ValidationException::withMessages([
                    'payment' => 'حالة الاشتراك لا تسمح بتفعيل هذه العملية.',
                ]);
            }

            $durationDays = $subscription->duration_days
                ?? $subscription->membershipPlan?->duration_days;

            if (! $durationDays || $durationDays < 1) {
                throw ValidationException::withMessages([
                    'payment' => 'مدة الاشتراك المرتبطة بعملية الدفع غير صالحة.',
                ]);
            }

            $startsAt = now();

            $endsAt = $startsAt->copy()->addDays($durationDays);

            $this->repository->update(
                $payment,
                [
                    'status' => PaymentStatus::PAID,
                    'paid_at' => $payment->paid_at ?? now(),
                ]
            );

            $this->subscriptionRepository->update(
                $subscription,
                [
                    'status' => SubscriptionStatus::ACTIVE,
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                ]
            );

            return $payment->fresh([
                'user',
                'subscription.membershipPlan',
            ]);
        });

        $this->notificationService->create(
            userId: $payment->user_id,
            title: 'تم تأكيد الدفع',
            message: "تم تأكيد عملية الدفع وتفعيل عضويتك في باقة {$payment->subscription->membershipPlan->name}.",
            type: 'payment',
            actionUrl: route('member.subscription'),
        );

        return $payment;
    }

    public function rejectPayment(
        int $paymentId,
        ?string $notes = null
    ): Payment {
        $payment = DB::transaction(function () use (
            $paymentId,
            $notes
        ) {
            $payment = $this->repository->findByIdForUpdate($paymentId);

            if (! $payment) {
                throw ValidationException::withMessages([
                    'payment' => 'عملية الدفع غير موجودة.',
                ]);
            }

            if ($payment->status !== PaymentStatus::PENDING) {
                throw ValidationException::withMessages([
                    'payment' => 'عملية الدفع تمت مراجعتها بالفعل.',
                ]);
            }

            if ($payment->method !== 'vodafone_cash') {
                throw ValidationException::withMessages([
                    'payment' => 'طريقة الدفع الحالية غير مدعومة للرفض.',
                ]);
            }

            if (! $payment->subscription) {
                throw ValidationException::withMessages([
                    'payment' => 'الاشتراك المرتبط بعملية الدفع غير موجود.',
                ]);
            }

            $subscription = $this->subscriptionRepository->findByIdForUpdate(
                $payment->subscription->id
            );

            if (! $subscription) {
                throw ValidationException::withMessages([
                    'payment' => 'الاشتراك المرتبط بعملية الدفع غير موجود.',
                ]);
            }

            if ($subscription->status !== SubscriptionStatus::PENDING) {
                throw ValidationException::withMessages([
                    'payment' => 'لا يمكن رفض عملية الدفع لأن حالة الاشتراك لا تسمح بذلك.',
                ]);
            }

            $this->repository->update(
                $payment,
                [
                    'status' => PaymentStatus::REJECTED,
                    'notes' => $notes,
                ]
            );

            $this->subscriptionRepository->update(
                $subscription,
                [
                    'status' => SubscriptionStatus::CANCELLED,
                ]
            );

            return $payment->fresh([
                'user',
                'subscription.membershipPlan',
            ]);
        });

        $message = 'تم رفض عملية الدفع.';

        if ($payment->notes) {
            $message .= " السبب: {$payment->notes}";
        }

        $this->notificationService->create(
            userId: $payment->user_id,
            title: 'تم رفض عملية الدفع',
            message: $message,
            type: 'payment',
            actionUrl: route('member.subscription'),
        );

        return $payment;
    }

    public function countPendingPayments(): int
    {
        return $this->repository->countPending();
    }
}

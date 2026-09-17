<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
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
        return DB::transaction(function () use (
            $paymentId,
            $userId,
            $transactionReference,
            $paidAt
        ) {

            $payment = $this->repository
                ->findByIdForUser($paymentId, $userId);

            if (! $payment) {
                throw ValidationException::withMessages([
                    'payment' => 'عملية الدفع غير موجودة.',
                ]);
            }

            if (
                $payment->status !== PaymentStatus::PENDING
            ) {
                throw ValidationException::withMessages([
                    'payment' => 'لا يمكن تعديل عملية الدفع الحالية.',
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
        return DB::transaction(function () use ($paymentId) {

            $payment = $this->repository->findById($paymentId);

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

            $subscription = $payment->subscription;

            if (
                $subscription->status
                !== SubscriptionStatus::PENDING
            ) {
                throw ValidationException::withMessages([
                    'payment' => 'حالة الاشتراك لا تسمح بتفعيل هذه العملية.',
                ]);
            }

            $startsAt = now();

            $endsAt = $startsAt->copy()->addDays(
                $subscription->membershipPlan->duration_days
            );

            $this->repository->update(
                $payment,
                [
                    'status' => PaymentStatus::PAID,
                    'paid_at' => $payment->paid_at ?? now(),
                ]
            );

            $subscription->update([
                'status' => SubscriptionStatus::ACTIVE,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
            ]);

            return $payment->fresh([
                'user',
                'subscription.membershipPlan',
            ]);
        });
    }

    public function rejectPayment(
        int $paymentId,
        ?string $notes = null
    ): Payment {
        return DB::transaction(function () use (
            $paymentId,
            $notes
        ) {

            $payment = $this->repository->findById($paymentId);

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

            $this->repository->update(
                $payment,
                [
                    'status' => PaymentStatus::REJECTED,
                    'notes' => $notes,
                ]
            );

            $payment->subscription->update([
                'status' => SubscriptionStatus::CANCELLED,
            ]);

            return $payment->fresh([
                'user',
                'subscription.membershipPlan',
            ]);
        });
    }

    public function countPendingPayments(): int
    {
        return $this->repository->countPending();
    }
}

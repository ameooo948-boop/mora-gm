<?php

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function __construct(
        protected Payment $model
    ) {}

    public function create(array $data): Payment
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function findById(int $id): ?Payment
    {
        return $this->model
            ->newQuery()
            ->with([
                'user',
                'subscription.membershipPlan',
            ])
            ->find($id);
    }

    public function findByIdForUser(
        int $id,
        int $userId
    ): ?Payment {
        return $this->model
            ->newQuery()
            ->with([
                'subscription.membershipPlan',
            ])
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function getByUser(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with('subscription.membershipPlan')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function update(
        Payment $payment,
        array $data
    ): Payment {
        $payment->update($data);

        return $payment->fresh([
            'subscription.membershipPlan',
        ]);
    }

    public function getPending(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with([
                'user',
                'subscription.membershipPlan',
            ])
            ->where('status', 'pending')
            ->whereNotNull('transaction_reference')
            ->latest()
            ->paginate($perPage);
    }

    public function getAll(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with([
                'user',
                'subscription.membershipPlan',
            ])
            ->latest()
            ->paginate($perPage);
    }

    public function countPending(): int
    {
        return $this->model
            ->newQuery()
            ->where('status', 'pending')
            ->whereNotNull('transaction_reference')
            ->count();
    }
}

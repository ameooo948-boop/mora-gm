<?php

namespace App\Repositories\Contracts;

use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentRepositoryInterface
{
    public function create(array $data): Payment;

    public function findById(int $id): ?Payment;

    public function findByIdForUser(
        int $id,
        int $userId
    ): ?Payment;

    public function getByUser(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function update(
        Payment $payment,
        array $data
    ): Payment;

    public function getPending(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getAll(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function countPending(): int;
}

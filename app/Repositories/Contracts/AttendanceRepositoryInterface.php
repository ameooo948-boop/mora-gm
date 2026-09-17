<?php

namespace App\Repositories\Contracts;

use App\Models\Attendance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AttendanceRepositoryInterface
{
    public function findForUserAndDate(
        int $userId,
        int $trainingSessionId,
        string $date
    ): ?Attendance;

    public function create(array $data): Attendance;

    public function update(
        Attendance $attendance,
        array $data
    ): Attendance;

    public function getByUser(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function getAll(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function countToday(): int;
}

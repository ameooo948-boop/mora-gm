<?php

namespace App\Repositories\Eloquent;

use App\Models\Attendance;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function __construct(
        protected Attendance $model
    ) {}

    public function findForUserAndDate(
        int $userId,
        int $trainingSessionId,
        string $date
    ): ?Attendance {
        return $this->model
            ->newQuery()
            ->where('user_id', $userId)
            ->where('training_session_id', $trainingSessionId)
            ->whereDate('attendance_date', $date)
            ->first();
    }

    public function create(array $data): Attendance
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        Attendance $attendance,
        array $data
    ): Attendance {
        $attendance->update($data);

        return $attendance->fresh([
            'trainingSession',
        ]);
    }

    public function getByUser(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with('trainingSession')
            ->where('user_id', $userId)
            ->latest('checked_in_at')
            ->paginate($perPage);
    }

    public function getAll(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with([
                'user',
                'trainingSession',
            ])
            ->latest('checked_in_at')
            ->paginate($perPage);
    }

    public function countToday(): int
    {
        return $this->model
            ->newQuery()
            ->whereDate('attendance_date', today())
            ->count();
    }
}

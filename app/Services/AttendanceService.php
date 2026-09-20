<?php

namespace App\Services;

use App\Enums\Gender;
use App\Models\Attendance;
use App\Models\TrainingSession;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AttendanceService
{
    public function __construct(
        protected AttendanceRepositoryInterface $repository,
        protected SubscriptionService $subscriptionService,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getUserAttendances(
        int $userId,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getByUser($userId, $perPage);
    }

    public function getAllAttendances(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll($perPage);
    }

    public function checkIn(
        int $userId,
        TrainingSession $trainingSession
    ): Attendance {
        $now = now();

        $this->ensureActiveMembership($userId);

        $this->ensureGenderMatchesSession(
            $userId,
            $trainingSession
        );

        if (! $trainingSession->is_active) {
            throw ValidationException::withMessages([
                'attendance' => 'هذه الجلسة غير متاحة حاليًا.',
            ]);
        }

        $this->ensureSessionIsOpen(
            $trainingSession,
            $now
        );

        $attendanceDate = $this->resolveAttendanceDate(
            $trainingSession,
            $now
        );

        try {
            return DB::transaction(function () use (
                $userId,
                $trainingSession,
                $attendanceDate,
                $now
            ) {
                $existing = $this->repository->findForUserAndDate(
                    $userId,
                    $trainingSession->id,
                    $attendanceDate->toDateString()
                );

                if ($existing) {
                    throw ValidationException::withMessages([
                        'attendance' => 'تم تسجيل حضورك لهذه الجلسة بالفعل.',
                    ]);
                }

                return $this->repository->create([
                    'user_id' => $userId,
                    'training_session_id' => $trainingSession->id,
                    'attendance_date' => $attendanceDate->toDateString(),
                    'checked_in_at' => $now,
                ]);
            });
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages([
                'attendance' => 'تم تسجيل حضورك لهذه الجلسة بالفعل.',
            ]);
        }
    }

    public function checkOut(
        int $userId,
        TrainingSession $trainingSession
    ): Attendance {
        $now = now();

        $this->ensureActiveMembership($userId);

        $this->ensureGenderMatchesSession(
            $userId,
            $trainingSession
        );

        $this->ensureSessionIsOpen(
            $trainingSession,
            $now
        );

        $attendanceDate = $this->resolveAttendanceDate(
            $trainingSession,
            $now
        );

        return DB::transaction(function () use (
            $userId,
            $trainingSession,
            $attendanceDate,
            $now
        ) {
            $attendance = $this->repository->findForUserAndDateForUpdate(
                $userId,
                $trainingSession->id,
                $attendanceDate->toDateString()
            );

            if (! $attendance) {
                throw ValidationException::withMessages([
                    'attendance' => 'لم يتم تسجيل حضورك لهذه الجلسة.',
                ]);
            }

            if ($attendance->checked_out_at) {
                throw ValidationException::withMessages([
                    'attendance' => 'تم تسجيل الانصراف لهذه الجلسة بالفعل.',
                ]);
            }

            return $this->repository->update($attendance, [
                'checked_out_at' => $now,
            ]);
        });
    }

    protected function ensureActiveMembership(int $userId): void
    {
        if (! $this->subscriptionService->hasActiveSubscription($userId)) {
            throw ValidationException::withMessages([
                'attendance' => 'لا يمكنك تسجيل الحضور بدون عضوية فعالة.',
            ]);
        }
    }

    protected function ensureSessionIsOpen(
        TrainingSession $session,
        Carbon $now
    ): void {
        if (! $session->starts_at || ! $session->ends_at) {
            throw ValidationException::withMessages([
                'attendance' => 'مواعيد هذه الجلسة غير مكتملة حاليًا.',
            ]);
        }

        $start = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $now->toDateString().' '.$session->starts_at
        );

        $end = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $now->toDateString().' '.$session->ends_at
        );

        if ($end->lessThanOrEqualTo($start)) {
            if ($now->lessThanOrEqualTo($end)) {
                $start->subDay();
            } else {
                $end->addDay();
            }
        }

        if (! $now->betweenIncluded($start, $end)) {
            throw ValidationException::withMessages([
                'attendance' => 'تسجيل الحضور متاح فقط خلال مواعيد الجلسة.',
            ]);
        }
    }

    protected function resolveAttendanceDate(
        TrainingSession $session,
        Carbon $now
    ): Carbon {
        if (! $session->starts_at || ! $session->ends_at) {
            return $now->copy()->startOfDay();
        }

        $startMinutes = $this->timeToMinutes(
            $session->starts_at
        );

        $endMinutes = $this->timeToMinutes(
            $session->ends_at
        );

        $currentMinutes = (
            ((int) $now->format('H')) * 60
        ) + ((int) $now->format('i'));

        if (
            $endMinutes <= $startMinutes
            && $currentMinutes <= $endMinutes
        ) {
            return $now->copy()->subDay()->startOfDay();
        }

        return $now->copy()->startOfDay();
    }

    protected function timeToMinutes(string $time): int
    {
        [$hours, $minutes] = array_map(
            'intval',
            explode(':', substr($time, 0, 5))
        );

        return ($hours * 60) + $minutes;
    }

    protected function ensureGenderMatchesSession(
        int $userId,
        TrainingSession $session
    ): void {
        $user = $this->userRepository->findById($userId);

        if (! $user || ! $user->gender) {
            throw ValidationException::withMessages([
                'attendance' => 'بيانات النوع الخاصة بحسابك غير مكتملة.',
            ]);
        }

        $expectedGender = match ($session->audience) {
            'Men' => Gender::MALE,
            'Women' => Gender::FEMALE,
            default => null,
        };

        if (
            $expectedGender !== null
            && $user->gender !== $expectedGender
        ) {
            throw ValidationException::withMessages([
                'attendance' => 'هذه الجلسة غير مخصصة لنوع حسابك.',
            ]);
        }
    }

    public function countToday(): int
    {
        return $this->repository->countToday();
    }
}

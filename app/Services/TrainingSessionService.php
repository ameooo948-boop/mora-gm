<?php

namespace App\Services;

use App\Enums\Gender;
use App\Models\TrainingSession;
use App\Repositories\Contracts\TrainerRepositoryInterface;
use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class TrainingSessionService
{
    public function __construct(
        protected TrainingSessionRepositoryInterface $repository,
        protected TrainerRepositoryInterface $trainerRepository
    ) {}

    public function getActiveSessions(): Collection
    {
        return $this->repository->getActive();
    }

    public function getAllSessions(
        ?string $audience = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll(
            $audience,
            $search,
            $perPage
        );
    }

    public function getSession(int $id): ?TrainingSession
    {
        return $this->repository->findById($id);
    }

    public function createSession(
        array $data,
        int $trainerId
    ): TrainingSession {
        return DB::transaction(function () use ($data, $trainerId) {
            $this->validateTrainerForAudience(
                $data['audience'],
                $trainerId
            );

            $session = $this->repository->create($data);

            return $this->repository->syncTrainers(
                $session,
                [$trainerId]
            );
        });
    }

    public function updateSession(
        TrainingSession $trainingSession,
        array $data,
        int $trainerId
    ): TrainingSession {
        return DB::transaction(function () use (
            $trainingSession,
            $data,
            $trainerId
        ) {
            $this->validateTrainerForAudience(
                $data['audience'],
                $trainerId
            );

            $session = $this->repository->update(
                $trainingSession,
                $data
            );

            return $this->repository->syncTrainers(
                $session,
                [$trainerId]
            );
        });
    }

    private function validateTrainerForAudience(
        string $audience,
        int $trainerId
    ): void {
        $gender = match ($audience) {
            'Men' => Gender::MALE->value,
            'Women' => Gender::FEMALE->value,
            default => null,
        };

        if ($gender === null) {
            throw ValidationException::withMessages([
                'audience' => 'نوع الجلسة غير صحيح.',
            ]);
        }

        $trainer = $this->trainerRepository->findByIdForUpdate($trainerId);

        $trainerMatches = $trainer
            && $trainer->is_active
            && $trainer->gender === $gender;

        if (! $trainerMatches) {
            throw ValidationException::withMessages([
                'trainer_id' => 'المدرب المختار لا يناسب نوع الجلسة أو أنه غير متاح حاليًا.',
            ]);
        }
    }
}

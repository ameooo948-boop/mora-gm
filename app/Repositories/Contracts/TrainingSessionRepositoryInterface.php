<?php

namespace App\Repositories\Contracts;

use App\Models\TrainingSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TrainingSessionRepositoryInterface
{
    public function getActive(): Collection;

    public function getAll(
        ?string $audience = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int $id): ?TrainingSession;

    public function create(array $data): TrainingSession;

    public function update(
        TrainingSession $trainingSession,
        array $data
    ): TrainingSession;

    public function syncTrainers(
        TrainingSession $trainingSession,
        array $trainerIds
    ): TrainingSession;
}

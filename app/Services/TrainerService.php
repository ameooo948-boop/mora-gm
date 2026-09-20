<?php

namespace App\Services;

use App\Models\Trainer;
use App\Repositories\Contracts\TrainerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TrainerService
{
    public function __construct(
        protected TrainerRepositoryInterface $repository
    ) {}

    public function getActiveTrainers(): Collection
    {
        return $this->repository->getActive();
    }

    public function getActiveTrainersByGender(string $gender): Collection
    {
        return $this->repository->getActiveByGender($gender);
    }

    public function getAllTrainers(
        ?string $gender = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll(
            $gender,
            $search,
            $perPage
        );
    }

    public function getTrainer(int $id): ?Trainer
    {
        return $this->repository->findById($id);
    }

    public function createTrainer(array $data): Trainer
    {
        return $this->repository->create($data);
    }

    public function updateTrainer(
        Trainer $trainer,
        array $data
    ): Trainer {
        return $this->repository->update(
            $trainer,
            $data
        );
    }
}

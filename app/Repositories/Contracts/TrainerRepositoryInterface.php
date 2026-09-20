<?php

namespace App\Repositories\Contracts;

use App\Models\Trainer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TrainerRepositoryInterface
{
    public function getActive(): Collection;

    public function getActiveByGender(string $gender): Collection;

    public function getAll(
        ?string $gender = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int $id): ?Trainer;

    public function create(array $data): Trainer;

    public function update(
        Trainer $trainer,
        array $data
    ): Trainer;
}

<?php

namespace App\Repositories\Eloquent;

use App\Models\GymProfile;
use App\Repositories\Contracts\GymProfileRepositoryInterface;
use Illuminate\Support\Collection;

class GymProfileRepository implements GymProfileRepositoryInterface
{
    public function __construct(
        protected GymProfile $model
    ) {}

    public function getActive(): ?GymProfile
    {
        return $this->model
            ->newQuery()
            ->active()
            ->first();
    }

    public function getAll(): Collection
    {
        return $this->model
            ->newQuery()
            ->latest('id')
            ->get();
    }

    public function findById(int $id): ?GymProfile
    {
        return $this->model
            ->newQuery()
            ->find($id);
    }

    public function create(array $data): GymProfile
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        GymProfile $gymProfile,
        array $data
    ): GymProfile {
        $gymProfile->update($data);

        return $gymProfile->fresh();
    }
}

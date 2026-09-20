<?php

namespace App\Services;

use App\Models\GymProfile;
use App\Repositories\Contracts\GymProfileRepositoryInterface;
use Illuminate\Support\Collection;

class GymProfileService
{
    public function __construct(
        protected GymProfileRepositoryInterface $repository
    ) {}

    public function getActiveProfile(): ?GymProfile
    {
        return $this->repository->getActive();
    }

    public function getAllProfiles(): Collection
    {
        return $this->repository->getAll();
    }

    public function getProfile(int $id): ?GymProfile
    {
        return $this->repository->findById($id);
    }

    public function createProfile(array $data): GymProfile
    {
        return $this->repository->create($data);
    }

    public function updateProfile(
        GymProfile $gymProfile,
        array $data
    ): GymProfile {
        return $this->repository->update(
            $gymProfile,
            $data
        );
    }
}

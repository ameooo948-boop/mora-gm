<?php

namespace App\Services;

use App\Models\GymProfile;
use App\Repositories\Contracts\GymProfileRepositoryInterface;

class GymProfileService
{
    public function __construct(
        protected GymProfileRepositoryInterface $repository
    ) {}

    public function getActiveProfile(): ?GymProfile
    {
        return $this->repository->getActive();
    }
}

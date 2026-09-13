<?php

namespace App\Repositories\Eloquent;

use App\Models\GymProfile;
use App\Repositories\Contracts\GymProfileRepositoryInterface;

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
}

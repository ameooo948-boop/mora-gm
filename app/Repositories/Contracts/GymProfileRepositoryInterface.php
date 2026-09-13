<?php

namespace App\Repositories\Contracts;

use App\Models\GymProfile;

interface GymProfileRepositoryInterface
{
    public function getActive(): ?GymProfile;
}

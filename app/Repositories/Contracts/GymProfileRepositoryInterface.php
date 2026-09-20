<?php

namespace App\Repositories\Contracts;

use App\Models\GymProfile;
use Illuminate\Support\Collection;

interface GymProfileRepositoryInterface
{
    public function getActive(): ?GymProfile;

    public function getAll(): Collection;

    public function findById(int $id): ?GymProfile;

    public function create(array $data): GymProfile;

    public function update(GymProfile $gymProfile, array $data): GymProfile;
}

<?php

namespace App\Services;

use App\Repositories\Contracts\TrainerRepositoryInterface;
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
}

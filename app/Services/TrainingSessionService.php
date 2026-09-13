<?php

namespace App\Services;

use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use Illuminate\Support\Collection;

class TrainingSessionService
{
    public function __construct(
        protected TrainingSessionRepositoryInterface $repository
    ) {}

    public function getActiveSessions(): Collection
    {
        return $this->repository->getActive();
    }
}

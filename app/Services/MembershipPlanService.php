<?php

namespace App\Services;

use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use Illuminate\Support\Collection;

class MembershipPlanService
{
    public function __construct(
        protected MembershipPlanRepositoryInterface $repository
    ) {}

    public function getActivePlans(): Collection
    {
        return $this->repository->getActive();
    }
}

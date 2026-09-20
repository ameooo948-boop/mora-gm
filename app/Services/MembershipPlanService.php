<?php

namespace App\Services;

use App\Models\MembershipPlan;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getAllPlans(
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll(
            $search,
            $perPage
        );
    }

    public function getPlan(int $id): ?MembershipPlan
    {
        return $this->repository->findById($id);
    }

    public function createPlan(array $data): MembershipPlan
    {
        return $this->repository->create($data);
    }

    public function updatePlan(
        MembershipPlan $membershipPlan,
        array $data
    ): MembershipPlan {
        return $this->repository->update(
            $membershipPlan,
            $data
        );
    }
}

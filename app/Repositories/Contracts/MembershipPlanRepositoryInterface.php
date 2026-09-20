<?php

namespace App\Repositories\Contracts;

use App\Models\MembershipPlan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MembershipPlanRepositoryInterface
{
    public function getActive(): Collection;

    public function getAll(
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int $id): ?MembershipPlan;

    public function findByIdForUpdate(int $id): ?MembershipPlan;

    public function create(array $data): MembershipPlan;

    public function update(
        MembershipPlan $membershipPlan,
        array $data
    ): MembershipPlan;
}

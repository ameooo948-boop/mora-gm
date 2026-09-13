<?php

namespace App\Repositories\Eloquent;

use App\Models\MembershipPlan;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use Illuminate\Support\Collection;

class MembershipPlanRepository implements MembershipPlanRepositoryInterface
{
    public function __construct(
        protected MembershipPlan $model
    ) {}

    public function getActive(): Collection
    {
        return $this->model
            ->newQuery()
            ->active()
            ->get();
    }
}

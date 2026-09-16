<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface MembershipPlanRepositoryInterface
{
    public function getActive(): Collection;
}

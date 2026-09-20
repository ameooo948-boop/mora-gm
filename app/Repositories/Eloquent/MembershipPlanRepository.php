<?php

namespace App\Repositories\Eloquent;

use App\Models\MembershipPlan;
use App\Repositories\Contracts\MembershipPlanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getAll(
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('duration_days')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id): ?MembershipPlan
    {
        return $this->model
            ->newQuery()
            ->find($id);
    }

    public function findByIdForUpdate(int $id): ?MembershipPlan
    {
        return $this->model
            ->newQuery()
            ->whereKey($id)
            ->lockForUpdate()
            ->first();
    }

    public function create(array $data): MembershipPlan
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        MembershipPlan $membershipPlan,
        array $data
    ): MembershipPlan {
        $membershipPlan->update($data);

        return $membershipPlan->fresh();
    }
}

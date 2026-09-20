<?php

namespace App\Repositories\Eloquent;

use App\Models\Trainer;
use App\Repositories\Contracts\TrainerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TrainerRepository implements TrainerRepositoryInterface
{
    public function __construct(
        protected Trainer $model
    ) {}

    public function getActive(): Collection
    {
        return $this->model
            ->newQuery()
            ->active()
            ->with('trainingSessions')
            ->get();
    }

    public function getActiveByGender(string $gender): Collection
    {
        return $this->model
            ->newQuery()
            ->active()
            ->where('gender', $gender)
            ->orderBy('sort_order')
            ->get();
    }

    public function getAll(
        ?string $gender = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with('trainingSessions')
            ->when($gender, function ($query) use ($gender) {
                $query->where('gender', $gender);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%")
                        ->orWhere('bio', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id): ?Trainer
    {
        return $this->model
            ->newQuery()
            ->with('trainingSessions')
            ->find($id);
    }

    public function create(array $data): Trainer
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        Trainer $trainer,
        array $data
    ): Trainer {
        $trainer->update($data);

        return $trainer->fresh([
            'trainingSessions',
        ]);
    }
}

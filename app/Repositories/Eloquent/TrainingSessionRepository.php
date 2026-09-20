<?php

namespace App\Repositories\Eloquent;

use App\Models\TrainingSession;
use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TrainingSessionRepository implements TrainingSessionRepositoryInterface
{
    public function __construct(
        protected TrainingSession $model
    ) {}

    public function getActive(): Collection
    {
        return $this->model
            ->newQuery()
            ->active()
            ->get();
    }

    public function getAll(
        ?string $audience = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with('trainers')
            ->when($audience, function ($query) use ($audience) {
                $query->where('audience', $audience);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('starts_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id): ?TrainingSession
    {
        return $this->model
            ->newQuery()
            ->with('trainers')
            ->find($id);
    }

    public function create(array $data): TrainingSession
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        TrainingSession $trainingSession,
        array $data
    ): TrainingSession {
        $trainingSession->update($data);

        return $trainingSession->fresh([
            'trainers',
        ]);
    }

    public function syncTrainers(
        TrainingSession $trainingSession,
        array $trainerIds
    ): TrainingSession {
        $trainingSession->trainers()->sync($trainerIds);

        return $trainingSession->fresh([
            'trainers',
        ]);
    }
}

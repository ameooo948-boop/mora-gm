<?php

namespace App\Repositories\Eloquent;

use App\Models\TrainingSession;
use App\Repositories\Contracts\TrainingSessionRepositoryInterface;
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
}

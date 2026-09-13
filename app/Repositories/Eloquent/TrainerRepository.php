<?php

namespace App\Repositories\Eloquent;

use App\Models\Trainer;
use App\Repositories\Contracts\TrainerRepositoryInterface;
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
}

<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface TrainingSessionRepositoryInterface
{
    public function getActive(): Collection;
}

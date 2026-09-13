<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface TrainerRepositoryInterface
{
    public function getActive(): Collection;
}

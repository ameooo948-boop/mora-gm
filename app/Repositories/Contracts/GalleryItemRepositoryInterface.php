<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface GalleryItemRepositoryInterface
{
    public function getActive(): Collection;
}

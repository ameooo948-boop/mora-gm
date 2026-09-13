<?php

namespace App\Services;

use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\Support\Collection;

class GalleryItemService
{
    public function __construct(
        protected GalleryItemRepositoryInterface $repository
    ) {}

    public function getActiveItems(): Collection
    {
        return $this->repository->getActive();
    }
}

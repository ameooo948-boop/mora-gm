<?php

namespace App\Repositories\Eloquent;

use App\Models\GalleryItem;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\Support\Collection;

class GalleryItemRepository implements GalleryItemRepositoryInterface
{
    public function __construct(
        protected GalleryItem $model
    ) {}

    public function getActive(): Collection
    {
        return $this->model
            ->newQuery()
            ->active()
            ->get();
    }
}

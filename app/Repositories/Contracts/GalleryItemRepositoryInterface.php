<?php

namespace App\Repositories\Contracts;

use App\Models\GalleryItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface GalleryItemRepositoryInterface
{
    public function getActive(): Collection;

    public function getAll(
        ?string $category = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findById(int $id): ?GalleryItem;

    public function create(array $data): GalleryItem;

    public function update(
        GalleryItem $galleryItem,
        array $data
    ): GalleryItem;

    public function delete(GalleryItem $galleryItem): bool;
}
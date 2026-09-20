<?php

namespace App\Services;

use App\Models\GalleryItem;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getAllItems(
        ?string $category = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getAll(
            $category,
            $search,
            $perPage
        );
    }

    public function getItem(int $id): ?GalleryItem
    {
        return $this->repository->findById($id);
    }

    public function createItem(array $data): GalleryItem
    {
        return $this->repository->create($data);
    }

    public function updateItem(
        GalleryItem $galleryItem,
        array $data
    ): GalleryItem {
        return $this->repository->update(
            $galleryItem,
            $data
        );
    }

    public function deleteItem(GalleryItem $galleryItem): bool
    {
        return $this->repository->delete($galleryItem);
    }
}

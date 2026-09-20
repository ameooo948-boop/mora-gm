<?php

namespace App\Repositories\Eloquent;

use App\Models\GalleryItem;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getAll(
        ?string $category = null,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(int $id): ?GalleryItem
    {
        return $this->model
            ->newQuery()
            ->find($id);
    }

    public function create(array $data): GalleryItem
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(
        GalleryItem $galleryItem,
        array $data
    ): GalleryItem {
        $galleryItem->update($data);

        return $galleryItem->fresh();
    }

    public function delete(GalleryItem $galleryItem): bool
    {
        return (bool) $galleryItem->delete();
    }
}

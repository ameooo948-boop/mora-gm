<?php

namespace App\Services;

use App\Models\GalleryItem;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
        $image = $data['image'];

        if ($image instanceof UploadedFile) {
            $data['image'] = $image->store('gallery', 'public');
        }

        return $this->repository->create($data);
    }

    public function updateItem(
        GalleryItem $galleryItem,
        array $data
    ): GalleryItem {
        $oldImage = $galleryItem->image;
        $newImage = null;

        try {
            if (
                isset($data['image']) &&
                $data['image'] instanceof UploadedFile
            ) {
                $newImage = $data['image']->store('gallery', 'public');

                $data['image'] = $newImage;
            } else {
                unset($data['image']);
            }

            $updatedItem = $this->repository->update(
                $galleryItem,
                $data
            );

            if (
                $newImage &&
                $oldImage &&
                Storage::disk('public')->exists($oldImage)
            ) {
                Storage::disk('public')->delete($oldImage);
            }

            return $updatedItem;

        } catch (Throwable $exception) {
            if (
                $newImage &&
                Storage::disk('public')->exists($newImage)
            ) {
                Storage::disk('public')->delete($newImage);
            }

            throw $exception;
        }
    }

    public function deleteItem(GalleryItem $galleryItem): bool
    {
        $image = $galleryItem->image;

        $deleted = $this->repository->delete($galleryItem);

        if (
            $deleted &&
            $image &&
            Storage::disk('public')->exists($image)
        ) {
            Storage::disk('public')->delete($image);
        }

        return $deleted;
    }
}

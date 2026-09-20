<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryItemRequest;
use App\Http\Requests\Admin\UpdateGalleryItemRequest;
use App\Services\GalleryItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryItemController extends Controller
{
    public function __construct(
        protected GalleryItemService $service
    ) {}

    public function index(Request $request): View
    {
        $category = $request->string('category')->trim()->value() ?: null;
        $search = $request->string('search')->trim()->value() ?: null;

        $items = $this->service->getAllItems(
            $category,
            $search
        );

        return view('admin.gallery.index', [
            'items' => $items,
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(StoreGalleryItemRequest $request): RedirectResponse
    {
        $this->service->createItem(
            $request->validated()
        );

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'تمت إضافة الصورة إلى المعرض بنجاح.');
    }

    public function edit(int $id): View
    {
        $item = $this->service->getItem($id);

        abort_if($item === null, 404);

        return view('admin.gallery.edit', [
            'item' => $item,
        ]);
    }

    public function update(
        UpdateGalleryItemRequest $request,
        int $id
    ): RedirectResponse {
        $item = $this->service->getItem($id);

        abort_if($item === null, 404);

        $this->service->updateItem(
            $item,
            $request->validated()
        );

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'تم تحديث الصورة بنجاح.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $item = $this->service->getItem($id);

        abort_if($item === null, 404);

        $this->service->deleteItem($item);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'تم حذف الصورة من المعرض بنجاح.');
    }
}

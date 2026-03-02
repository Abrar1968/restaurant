<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryCategoryRequest;
use App\Services\Admin\GalleryAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryCategoryController extends Controller
{
    public function __construct(protected GalleryAdminService $galleryAdminService) {}

    public function index(): View
    {
        return view('admin.gallery-categories.index', [
            'categories' => $this->galleryAdminService->getAllCategories(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery-categories.create');
    }

    public function store(StoreGalleryCategoryRequest $request): RedirectResponse
    {
        $this->galleryAdminService->createCategory($request->validated());

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.gallery-categories.edit', [
            'category' => $this->galleryAdminService->findCategoryOrFail($id),
        ]);
    }

    public function update(StoreGalleryCategoryRequest $request, int $id): RedirectResponse
    {
        $this->galleryAdminService->updateCategory($id, $request->validated());

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->galleryAdminService->deleteCategory($id);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category deleted successfully.');
    }
}

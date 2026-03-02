<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\GalleryAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryCategoryController extends Controller
{
    public function __construct(protected GalleryAdminService $galleryAdminService) {}

    public function index(): View
    {
        return view('admin.gallery.categories.index', [
            'categories' => $this->galleryAdminService->getAllCategories(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->galleryAdminService->createCategory($request->all());

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.gallery.categories.edit', [
            'category' => $this->galleryAdminService->findCategoryOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->galleryAdminService->updateCategory($id, $request->all());

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->galleryAdminService->deleteCategory($id);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Gallery category deleted successfully.');
    }
}

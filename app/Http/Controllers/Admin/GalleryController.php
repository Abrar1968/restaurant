<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryImageRequest;
use App\Services\Admin\GalleryAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(protected GalleryAdminService $galleryAdminService) {}

    public function index(): View
    {
        return view('admin.gallery.index', [
            'images' => $this->galleryAdminService->getAllImages(),
            'categories' => $this->galleryAdminService->getAllCategories(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'categories' => $this->galleryAdminService->getAllCategories(),
        ]);
    }

    public function store(StoreGalleryImageRequest $request): RedirectResponse
    {
        $this->galleryAdminService->createImage(
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image added successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.gallery.edit', [
            'image' => $this->galleryAdminService->findImageOrFail($id),
            'categories' => $this->galleryAdminService->getAllCategories(),
        ]);
    }

    public function update(StoreGalleryImageRequest $request, int $id): RedirectResponse
    {
        $this->galleryAdminService->updateImage(
            $id,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->galleryAdminService->deleteImage($id);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image deleted successfully.');
    }
}

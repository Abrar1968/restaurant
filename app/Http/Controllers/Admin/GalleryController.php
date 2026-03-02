<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\GalleryAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(protected GalleryAdminService $galleryAdminService) {}

    public function index(): View
    {
        return view('admin.gallery.index', [
            'images' => $this->galleryAdminService->getAllImages(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'categories' => $this->galleryAdminService->getAllCategories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->galleryAdminService->createImage(
            $request->all(),
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

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->galleryAdminService->updateImage(
            $id,
            $request->all(),
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

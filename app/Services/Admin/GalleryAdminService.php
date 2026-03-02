<?php

namespace App\Services\Admin;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Repositories\GalleryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class GalleryAdminService
{
    public function __construct(
        protected GalleryRepository $galleryRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    // ──────────────────────────────────────────────
    // Categories
    // ──────────────────────────────────────────────

    /**
     * Get all gallery categories.
     */
    public function getAllCategories(): Collection
    {
        return $this->galleryRepo->getCategories();
    }

    /**
     * Find a gallery category by ID.
     */
    public function findCategory(int $id): GalleryCategory
    {
        return $this->galleryRepo->findCategoryOrFail($id);
    }

    /**
     * Find a gallery category by ID or fail (alias).
     */
    public function findCategoryOrFail(int $id): GalleryCategory
    {
        return $this->findCategory($id);
    }

    /**
     * Create a new gallery category.
     *
     * @param  array<string, mixed>  $data
     */
    public function createCategory(array $data): GalleryCategory
    {
        return $this->galleryRepo->createCategory($data);
    }

    /**
     * Update a gallery category.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateCategory(int $id, array $data): GalleryCategory
    {
        return $this->galleryRepo->updateCategory($id, $data);
    }

    /**
     * Delete a gallery category.
     */
    public function deleteCategory(int $id): void
    {
        $this->galleryRepo->deleteCategory($id);
    }

    // ──────────────────────────────────────────────
    // Images
    // ──────────────────────────────────────────────

    /**
     * Get all active gallery images.
     */
    public function getAllImages(): Collection
    {
        return $this->galleryRepo->getActiveImages();
    }

    /**
     * Find a gallery image by ID.
     */
    public function findImage(int $id): GalleryImage
    {
        return $this->galleryRepo->findImageOrFail($id);
    }

    /**
     * Find a gallery image by ID or fail (alias).
     */
    public function findImageOrFail(int $id): GalleryImage
    {
        return $this->findImage($id);
    }

    /**
     * Create a new gallery image with file upload.
     *
     * @param  array<string, mixed>  $data
     */
    public function createImage(array $data, UploadedFile $image): GalleryImage
    {
        $data['image_path'] = $this->imageUploadService->upload($image, 'gallery');

        return $this->galleryRepo->createImage($data);
    }

    /**
     * Update a gallery image with optional image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateImage(int $id, array $data, ?UploadedFile $image = null): GalleryImage
    {
        if ($image) {
            $galleryImage = $this->galleryRepo->findImageOrFail($id);
            $data['image_path'] = $this->imageUploadService->replace($galleryImage->image_path, $image, 'gallery');
        }

        return $this->galleryRepo->updateImage($id, $data);
    }

    /**
     * Delete a gallery image and its file.
     */
    public function deleteImage(int $id): void
    {
        $galleryImage = $this->galleryRepo->findImageOrFail($id);
        $this->imageUploadService->delete($galleryImage->image_path);
        $this->galleryRepo->deleteImage($id);
    }
}

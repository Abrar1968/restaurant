<?php

namespace App\Repositories;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Collection;

class GalleryRepository
{
    /**
     * Get all active gallery images with eager loaded category.
     */
    public function getActiveImages(): Collection
    {
        return GalleryImage::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get active images for a specific category.
     */
    public function getByCategory(int $categoryId): Collection
    {
        return GalleryImage::query()
            ->where('gallery_category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all gallery categories ordered by sort_order.
     */
    public function getCategories(): Collection
    {
        return GalleryCategory::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a gallery image by ID or throw an exception.
     */
    public function findImageOrFail(int $id): GalleryImage
    {
        return GalleryImage::query()->findOrFail($id);
    }

    /**
     * Create a new gallery image.
     *
     * @param  array<string, mixed>  $data
     */
    public function createImage(array $data): GalleryImage
    {
        return GalleryImage::query()->create($data);
    }

    /**
     * Update an existing gallery image.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateImage(int $id, array $data): GalleryImage
    {
        $image = GalleryImage::query()->findOrFail($id);
        $image->update($data);

        return $image;
    }

    /**
     * Delete a gallery image.
     */
    public function deleteImage(int $id): void
    {
        $image = GalleryImage::query()->findOrFail($id);
        $image->delete();
    }

    /**
     * Find a gallery category by ID or throw an exception.
     */
    public function findCategoryOrFail(int $id): GalleryCategory
    {
        return GalleryCategory::query()->findOrFail($id);
    }

    /**
     * Create a new gallery category.
     *
     * @param  array<string, mixed>  $data
     */
    public function createCategory(array $data): GalleryCategory
    {
        return GalleryCategory::query()->create($data);
    }

    /**
     * Update an existing gallery category.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateCategory(int $id, array $data): GalleryCategory
    {
        $category = GalleryCategory::query()->findOrFail($id);
        $category->update($data);

        return $category;
    }

    /**
     * Delete a gallery category.
     */
    public function deleteCategory(int $id): void
    {
        $category = GalleryCategory::query()->findOrFail($id);
        $category->delete();
    }
}

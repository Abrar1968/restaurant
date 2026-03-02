<?php

namespace App\Services\Admin;

use App\Models\Package;
use App\Models\PackageImage;
use App\Models\PackageItem;
use App\Repositories\PackageRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class PackageAdminService
{
    public function __construct(
        protected PackageRepository $packageRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    // ──────────────────────────────────────────────
    // Packages
    // ──────────────────────────────────────────────

    /**
     * Get all packages ordered by sort_order.
     */
    public function getAllPackages(): Collection
    {
        return $this->packageRepo->getAll();
    }

    /**
     * Get all packages (alias).
     */
    public function getAll(): Collection
    {
        return $this->getAllPackages();
    }

    /**
     * Find a package by ID with eager loaded relations.
     */
    public function findPackage(int $id): Package
    {
        return Package::query()->with(['items', 'images'])->findOrFail($id);
    }

    /**
     * Find a package by ID (alias).
     */
    public function findOrFail(int $id): Package
    {
        return $this->findPackage($id);
    }

    /**
     * Create a new package with optional cover image.
     *
     * @param  array<string, mixed>  $data
     */
    public function createPackage(array $data, ?UploadedFile $image = null): Package
    {
        if ($image) {
            $data['cover_image_path'] = $this->imageUploadService->upload($image, 'packages');
        }

        return $this->packageRepo->create($data);
    }

    /**
     * Create a new package (alias).
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $image = null): Package
    {
        return $this->createPackage($data, $image);
    }

    /**
     * Update a package with optional cover image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function updatePackage(int $id, array $data, ?UploadedFile $image = null): Package
    {
        if ($image) {
            $package = Package::query()->findOrFail($id);
            $data['cover_image_path'] = $this->imageUploadService->replace($package->cover_image_path, $image, 'packages');
        }

        return $this->packageRepo->update($id, $data);
    }

    /**
     * Update a package (alias).
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data, ?UploadedFile $image = null): Package
    {
        return $this->updatePackage($id, $data, $image);
    }

    /**
     * Delete a package, its cover image, and all associated package images.
     */
    public function deletePackage(int $id): void
    {
        $package = Package::query()->with('images')->findOrFail($id);
        $this->imageUploadService->delete($package->cover_image_path);

        foreach ($package->images as $packageImage) {
            $this->imageUploadService->delete($packageImage->image_path);
        }

        $this->packageRepo->delete($id);
    }

    /**
     * Delete a package (alias).
     */
    public function delete(int $id): void
    {
        $this->deletePackage($id);
    }

    // ──────────────────────────────────────────────
    // Package Items
    // ──────────────────────────────────────────────

    /**
     * Create a new package item.
     *
     * @param  array<string, mixed>  $data
     */
    public function createItem(array $data): PackageItem
    {
        return PackageItem::query()->create($data);
    }

    /**
     * Update a package item.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateItem(int $id, array $data): PackageItem
    {
        $item = PackageItem::query()->findOrFail($id);
        $item->update($data);

        return $item;
    }

    /**
     * Delete a package item.
     */
    public function deleteItem(int $id): void
    {
        $item = PackageItem::query()->findOrFail($id);
        $item->delete();
    }

    // ──────────────────────────────────────────────
    // Package Images
    // ──────────────────────────────────────────────

    /**
     * Add a new image to a package.
     *
     * @param  array<string, mixed>  $data
     */
    public function createImage(array $data, UploadedFile $image): PackageImage
    {
        $data['image_path'] = $this->imageUploadService->upload($image, 'package-images');

        return PackageImage::query()->create($data);
    }

    /**
     * Update a package image with optional image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateImage(int $id, array $data, ?UploadedFile $image = null): PackageImage
    {
        $packageImage = PackageImage::query()->findOrFail($id);

        if ($image) {
            $data['image_path'] = $this->imageUploadService->replace($packageImage->image_path, $image, 'package-images');
        }

        $packageImage->update($data);

        return $packageImage;
    }

    /**
     * Delete a package image and its file.
     */
    public function deleteImage(int $id): void
    {
        $packageImage = PackageImage::query()->findOrFail($id);
        $this->imageUploadService->delete($packageImage->image_path);
        $packageImage->delete();
    }
}

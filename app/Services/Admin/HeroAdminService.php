<?php

namespace App\Services\Admin;

use App\Models\HeroSlide;
use App\Repositories\HeroRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class HeroAdminService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    /**
     * Get all hero slides for a specific page.
     */
    public function getAllForPage(string $page): Collection
    {
        return $this->heroRepo->getAllForPage($page);
    }

    /**
     * Find a hero slide by ID.
     */
    public function find(int $id): HeroSlide
    {
        return $this->heroRepo->findOrFail($id);
    }

    /**
     * Create a new hero slide with optional image upload.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $image = null): HeroSlide
    {
        if ($image) {
            $data['image_path'] = $this->imageUploadService->upload($image, 'hero');
        }

        return $this->heroRepo->create($data);
    }

    /**
     * Update an existing hero slide with optional image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data, ?UploadedFile $image = null): HeroSlide
    {
        if ($image) {
            $heroSlide = $this->heroRepo->findOrFail($id);
            $data['image_path'] = $this->imageUploadService->replace($heroSlide->image_path, $image, 'hero');
        }

        return $this->heroRepo->update($id, $data);
    }

    /**
     * Delete a hero slide and its associated image.
     */
    public function delete(int $id): void
    {
        $heroSlide = $this->heroRepo->findOrFail($id);
        $this->imageUploadService->delete($heroSlide->image_path);
        $this->heroRepo->delete($id);
    }
}

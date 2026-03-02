<?php

namespace App\Repositories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Collection;

class HeroRepository
{
    /**
     * Get active hero slides for a specific page.
     */
    public function getActiveForPage(string $page): Collection
    {
        return HeroSlide::query()
            ->where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all hero slides for a specific page (active and inactive).
     */
    public function getAllForPage(string $page): Collection
    {
        return HeroSlide::query()
            ->where('page', $page)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a hero slide by ID or throw an exception.
     */
    public function findOrFail(int $id): HeroSlide
    {
        return HeroSlide::query()->findOrFail($id);
    }

    /**
     * Create a new hero slide.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): HeroSlide
    {
        return HeroSlide::query()->create($data);
    }

    /**
     * Update an existing hero slide.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): HeroSlide
    {
        $heroSlide = HeroSlide::query()->findOrFail($id);
        $heroSlide->update($data);

        return $heroSlide;
    }

    /**
     * Delete a hero slide.
     */
    public function delete(int $id): void
    {
        $heroSlide = HeroSlide::query()->findOrFail($id);
        $heroSlide->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;

class PackageRepository
{
    /**
     * Get all active packages, ordered by sort_order.
     */
    public function getActivePackages(): Collection
    {
        return Package::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a package by slug with eager loaded items and images.
     */
    public function findBySlug(string $slug): Package
    {
        return Package::query()
            ->with(['items' => fn ($q) => $q->orderBy('sort_order'), 'images' => fn ($q) => $q->orderBy('sort_order')])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * Get all packages ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return Package::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Create a new package.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Package
    {
        return Package::query()->create($data);
    }

    /**
     * Update an existing package.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Package
    {
        $package = Package::query()->findOrFail($id);
        $package->update($data);

        return $package;
    }

    /**
     * Delete a package.
     */
    public function delete(int $id): void
    {
        $package = Package::query()->findOrFail($id);
        $package->delete();
    }
}

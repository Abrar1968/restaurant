<?php

namespace App\Repositories;

use App\Models\Certification;
use Illuminate\Database\Eloquent\Collection;

class CertificationRepository
{
    /**
     * Get all active certifications ordered by sort_order.
     */
    public function getActive(): Collection
    {
        return Certification::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all certifications ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return Certification::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a certification by ID or throw an exception.
     */
    public function findOrFail(int $id): Certification
    {
        return Certification::query()->findOrFail($id);
    }

    /**
     * Create a new certification.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Certification
    {
        return Certification::query()->create($data);
    }

    /**
     * Update an existing certification.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Certification
    {
        $certification = Certification::query()->findOrFail($id);
        $certification->update($data);

        return $certification;
    }

    /**
     * Delete a certification.
     */
    public function delete(int $id): void
    {
        $certification = Certification::query()->findOrFail($id);
        $certification->delete();
    }
}

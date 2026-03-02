<?php

namespace App\Repositories;

use App\Models\TrackRecord;
use Illuminate\Database\Eloquent\Collection;

class TrackRecordRepository
{
    /**
     * Get all track records ordered by year descending, then sort_order.
     */
    public function getAllOrdered(): Collection
    {
        return TrackRecord::query()
            ->orderByDesc('year')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all track records ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return TrackRecord::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a track record by ID or throw an exception.
     */
    public function findOrFail(int $id): TrackRecord
    {
        return TrackRecord::query()->findOrFail($id);
    }

    /**
     * Create a new track record.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): TrackRecord
    {
        return TrackRecord::query()->create($data);
    }

    /**
     * Update an existing track record.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): TrackRecord
    {
        $trackRecord = TrackRecord::query()->findOrFail($id);
        $trackRecord->update($data);

        return $trackRecord;
    }

    /**
     * Delete a track record.
     */
    public function delete(int $id): void
    {
        $trackRecord = TrackRecord::query()->findOrFail($id);
        $trackRecord->delete();
    }
}

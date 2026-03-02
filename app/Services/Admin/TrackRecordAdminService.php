<?php

namespace App\Services\Admin;

use App\Models\TrackRecord;
use App\Repositories\TrackRecordRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class TrackRecordAdminService
{
    public function __construct(
        protected TrackRecordRepository $trackRecordRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    /**
     * Get all track records ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return $this->trackRecordRepo->getAll();
    }

    /**
     * Find a track record by ID.
     */
    public function find(int $id): TrackRecord
    {
        return $this->trackRecordRepo->findOrFail($id);
    }

    /**
     * Create a new track record with optional image upload.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $image = null): TrackRecord
    {
        if ($image) {
            $data['image_path'] = $this->imageUploadService->upload($image, 'track-records');
        }

        return $this->trackRecordRepo->create($data);
    }

    /**
     * Update a track record with optional image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data, ?UploadedFile $image = null): TrackRecord
    {
        if ($image) {
            $trackRecord = $this->trackRecordRepo->findOrFail($id);
            $data['image_path'] = $this->imageUploadService->replace($trackRecord->image_path, $image, 'track-records');
        }

        return $this->trackRecordRepo->update($id, $data);
    }

    /**
     * Delete a track record and its image.
     */
    public function delete(int $id): void
    {
        $trackRecord = $this->trackRecordRepo->findOrFail($id);
        $this->imageUploadService->delete($trackRecord->image_path);
        $this->trackRecordRepo->delete($id);
    }
}

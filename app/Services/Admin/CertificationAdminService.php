<?php

namespace App\Services\Admin;

use App\Models\Certification;
use App\Repositories\CertificationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class CertificationAdminService
{
    public function __construct(
        protected CertificationRepository $certificationRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    /**
     * Get all certifications ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return $this->certificationRepo->getAll();
    }

    /**
     * Find a certification by ID.
     */
    public function find(int $id): Certification
    {
        return $this->certificationRepo->findOrFail($id);
    }

    /**
     * Find a certification by ID or fail (alias).
     */
    public function findOrFail(int $id): Certification
    {
        return $this->find($id);
    }

    /**
     * Create a new certification with optional image upload.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $image = null): Certification
    {
        if ($image) {
            $data['certificate_image_path'] = $this->imageUploadService->upload($image, 'certifications');
        }

        return $this->certificationRepo->create($data);
    }

    /**
     * Update a certification with optional image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data, ?UploadedFile $image = null): Certification
    {
        if ($image) {
            $certification = $this->certificationRepo->findOrFail($id);
            $data['certificate_image_path'] = $this->imageUploadService->replace($certification->certificate_image_path, $image, 'certifications');
        }

        return $this->certificationRepo->update($id, $data);
    }

    /**
     * Delete a certification and its image.
     */
    public function delete(int $id): void
    {
        $certification = $this->certificationRepo->findOrFail($id);
        $this->imageUploadService->delete($certification->certificate_image_path);
        $this->certificationRepo->delete($id);
    }
}

<?php

namespace App\Services\Admin;

use App\Models\TeamMember;
use App\Repositories\TeamMemberRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class TeamAdminService
{
    public function __construct(
        protected TeamMemberRepository $teamMemberRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    /**
     * Get all team members ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return $this->teamMemberRepo->getAll();
    }

    /**
     * Find a team member by ID.
     */
    public function find(int $id): TeamMember
    {
        return $this->teamMemberRepo->findOrFail($id);
    }

    /**
     * Create a new team member with optional photo upload.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $photo = null): TeamMember
    {
        if ($photo) {
            $data['photo_path'] = $this->imageUploadService->upload($photo, 'team');
        }

        return $this->teamMemberRepo->create($data);
    }

    /**
     * Update a team member with optional photo replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data, ?UploadedFile $photo = null): TeamMember
    {
        if ($photo) {
            $teamMember = $this->teamMemberRepo->findOrFail($id);
            $data['photo_path'] = $this->imageUploadService->replace($teamMember->photo_path, $photo, 'team');
        }

        return $this->teamMemberRepo->update($id, $data);
    }

    /**
     * Delete a team member and their photo.
     */
    public function delete(int $id): void
    {
        $teamMember = $this->teamMemberRepo->findOrFail($id);
        $this->imageUploadService->delete($teamMember->photo_path);
        $this->teamMemberRepo->delete($id);
    }
}

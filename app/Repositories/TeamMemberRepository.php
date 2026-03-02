<?php

namespace App\Repositories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Collection;

class TeamMemberRepository
{
    /**
     * Get all active team members ordered by sort_order.
     */
    public function getActive(): Collection
    {
        return TeamMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all team members ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return TeamMember::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a team member by ID or throw an exception.
     */
    public function findOrFail(int $id): TeamMember
    {
        return TeamMember::query()->findOrFail($id);
    }

    /**
     * Create a new team member.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): TeamMember
    {
        return TeamMember::query()->create($data);
    }

    /**
     * Update an existing team member.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): TeamMember
    {
        $teamMember = TeamMember::query()->findOrFail($id);
        $teamMember->update($data);

        return $teamMember;
    }

    /**
     * Delete a team member.
     */
    public function delete(int $id): void
    {
        $teamMember = TeamMember::query()->findOrFail($id);
        $teamMember->delete();
    }
}

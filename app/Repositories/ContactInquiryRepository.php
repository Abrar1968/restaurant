<?php

namespace App\Repositories;

use App\Models\ContactInquiry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactInquiryRepository
{
    /**
     * Get all contact inquiries paginated, ordered by newest first.
     */
    public function getAll(): LengthAwarePaginator
    {
        return ContactInquiry::query()
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    /**
     * Get the count of new (unread) inquiries.
     */
    public function getNewCount(): int
    {
        return ContactInquiry::query()
            ->where('status', 'new')
            ->count();
    }

    /**
     * Find a contact inquiry by ID or throw an exception.
     */
    public function findOrFail(int $id): ContactInquiry
    {
        return ContactInquiry::query()->findOrFail($id);
    }

    /**
     * Create a new contact inquiry.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): ContactInquiry
    {
        return ContactInquiry::query()->create($data);
    }

    /**
     * Update the status of a contact inquiry.
     */
    public function updateStatus(int $id, string $status): ContactInquiry
    {
        $inquiry = ContactInquiry::query()->findOrFail($id);
        $inquiry->update(['status' => $status]);

        return $inquiry;
    }

    /**
     * Delete a contact inquiry.
     */
    public function delete(int $id): void
    {
        $inquiry = ContactInquiry::query()->findOrFail($id);
        $inquiry->delete();
    }
}

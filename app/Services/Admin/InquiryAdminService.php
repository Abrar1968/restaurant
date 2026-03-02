<?php

namespace App\Services\Admin;

use App\Models\ContactInquiry;
use App\Repositories\ContactInquiryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InquiryAdminService
{
    public function __construct(
        protected ContactInquiryRepository $contactInquiryRepo,
    ) {}

    /**
     * Get all contact inquiries paginated.
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->contactInquiryRepo->getAll();
    }

    /**
     * Get the count of new (unread) inquiries.
     */
    public function getNewCount(): int
    {
        return $this->contactInquiryRepo->getNewCount();
    }

    /**
     * Find a contact inquiry by ID.
     */
    public function find(int $id): ContactInquiry
    {
        return $this->contactInquiryRepo->findOrFail($id);
    }

    /**
     * Update the status of a contact inquiry.
     */
    public function updateStatus(int $id, string $status): ContactInquiry
    {
        return $this->contactInquiryRepo->updateStatus($id, $status);
    }

    /**
     * Delete a contact inquiry.
     */
    public function delete(int $id): void
    {
        $this->contactInquiryRepo->delete($id);
    }
}

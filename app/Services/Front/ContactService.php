<?php

namespace App\Services\Front;

use App\Models\ContactInquiry;
use App\Repositories\ContactInquiryRepository;
use App\Repositories\HeroRepository;
use App\Repositories\SettingRepository;

class ContactService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected ContactInquiryRepository $contactInquiryRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the contact page.
     *
     * @return array<string, mixed>
     */
    public function getContactData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('contact'),
            'settings' => $this->settingRepo->getAll(),
        ];
    }

    /**
     * Submit a new contact inquiry.
     *
     * @param  array<string, mixed>  $data
     */
    public function submitInquiry(array $data): ContactInquiry
    {
        return $this->contactInquiryRepo->create($data);
    }
}

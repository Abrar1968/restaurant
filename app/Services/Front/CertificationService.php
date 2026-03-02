<?php

namespace App\Services\Front;

use App\Repositories\CertificationRepository;
use App\Repositories\HeroRepository;
use App\Repositories\SettingRepository;

class CertificationService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected CertificationRepository $certificationRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the certifications page.
     *
     * @return array<string, mixed>
     */
    public function getCertificationData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('certifications'),
            'certifications' => $this->certificationRepo->getActive(),
            'settings' => $this->settingRepo->getAll(),
        ];
    }
}

<?php

namespace App\Services\Front;

use App\Repositories\GalleryRepository;
use App\Repositories\HeroRepository;
use App\Repositories\SettingRepository;

class GalleryService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected GalleryRepository $galleryRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the gallery page.
     *
     * @return array<string, mixed>
     */
    public function getGalleryData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('gallery'),
            'images' => $this->galleryRepo->getActiveImages(),
            'categories' => $this->galleryRepo->getCategories(),
            'settings' => $this->settingRepo->getAll(),
        ];
    }
}

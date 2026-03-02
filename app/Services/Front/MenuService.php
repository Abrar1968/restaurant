<?php

namespace App\Services\Front;

use App\Repositories\HeroRepository;
use App\Repositories\MenuRepository;
use App\Repositories\PackageRepository;
use App\Repositories\SettingRepository;

class MenuService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected MenuRepository $menuRepo,
        protected PackageRepository $packageRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the menu index page.
     *
     * @return array<string, mixed>
     */
    public function getMenuIndexData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('menu'),
            'cuisines' => $this->menuRepo->getActiveCuisines(),
            'packages' => $this->packageRepo->getActivePackages(),
            'settings' => $this->settingRepo->getAll(),
        ];
    }

    /**
     * Get data for a specific cuisine (menu) page by slug.
     *
     * @return array<string, mixed>
     */
    public function getCuisineData(string $slug): array
    {
        return [
            'menu' => $this->menuRepo->findBySlug($slug),
            'settings' => $this->settingRepo->getAll(),
        ];
    }

    /**
     * Get data for a specific package page by slug.
     *
     * @return array<string, mixed>
     */
    public function getPackageData(string $slug): array
    {
        return [
            'package' => $this->packageRepo->findBySlug($slug),
            'settings' => $this->settingRepo->getAll(),
        ];
    }
}

<?php

namespace App\Services\Front;

use App\Repositories\ClientRepository;
use App\Repositories\HeroRepository;
use App\Repositories\MenuRepository;
use App\Repositories\PackageRepository;
use App\Repositories\SettingRepository;

class HomePageService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected ClientRepository $clientRepo,
        protected PackageRepository $packageRepo,
        protected MenuRepository $menuRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the home page.
     *
     * @return array<string, mixed>
     */
    public function getHomeData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('home'),
            'packages' => $this->packageRepo->getActivePackages(),
            'cuisines' => $this->menuRepo->getActiveCuisines(),
            'clients' => $this->clientRepo->getMarqueeClients(),
            'settings' => $this->settingRepo->getAll(),
        ];
    }
}

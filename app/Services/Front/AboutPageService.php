<?php

namespace App\Services\Front;

use App\Repositories\HeroRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TeamMemberRepository;

class AboutPageService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected SettingRepository $settingRepo,
        protected TeamMemberRepository $teamMemberRepo,
    ) {}

    /**
     * Get all data needed for the about page.
     *
     * @return array<string, mixed>
     */
    public function getAboutData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('about'),
            'settings' => $this->settingRepo->getAll(),
            'teamMembers' => $this->teamMemberRepo->getActive(),
        ];
    }
}

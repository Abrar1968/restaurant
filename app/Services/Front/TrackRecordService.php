<?php

namespace App\Services\Front;

use App\Repositories\HeroRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TrackRecordRepository;

class TrackRecordService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected TrackRecordRepository $trackRecordRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the track record page.
     *
     * @return array<string, mixed>
     */
    public function getTrackRecordData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('track-record'),
            'records' => $this->trackRecordRepo->getAllOrdered(),
            'settings' => $this->settingRepo->getAll(),
        ];
    }
}

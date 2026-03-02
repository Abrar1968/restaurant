<?php

namespace App\Services\Admin;

use App\Repositories\SettingRepository;

class SettingService
{
    public function __construct(
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all settings as a key-value array.
     *
     * @return array<string, string|null>
     */
    public function getAll(): array
    {
        return $this->settingRepo->getAll();
    }

    /**
     * Update multiple settings at once.
     *
     * @param  array<string, string|null>  $data
     */
    public function update(array $data): void
    {
        $this->settingRepo->setMany($data);
    }
}

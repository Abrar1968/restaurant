<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingRepository
{
    /**
     * Get all settings as a key-value array, cached for 1 hour.
     *
     * @return array<string, string|null>
     */
    public function getAll(): array
    {
        return Cache::remember('settings', 3600, fn () => Setting::query()->pluck('value', 'key')->toArray()
        );
    }

    /**
     * Get a single setting value by key.
     */
    public function get(string $key, ?string $default = null): ?string
    {
        $settings = $this->getAll();

        return $settings[$key] ?? $default;
    }

    /**
     * Set a single setting value.
     */
    public function set(string $key, ?string $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }

    /**
     * Set multiple settings at once.
     *
     * @param  array<string, string|null>  $settings
     */
    public function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('settings');
    }
}

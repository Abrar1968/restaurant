<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Repositories\SettingRepository::class);
        $this->app->bind(\App\Repositories\HeroRepository::class);
        $this->app->bind(\App\Repositories\MenuRepository::class);
        $this->app->bind(\App\Repositories\MenuCategoryRepository::class);
        $this->app->bind(\App\Repositories\MenuItemRepository::class);
        $this->app->bind(\App\Repositories\PackageRepository::class);
        $this->app->bind(\App\Repositories\GalleryRepository::class);
        $this->app->bind(\App\Repositories\ClientRepository::class);
        $this->app->bind(\App\Repositories\CertificationRepository::class);
        $this->app->bind(\App\Repositories\TrackRecordRepository::class);
        $this->app->bind(\App\Repositories\TeamMemberRepository::class);
        $this->app->bind(\App\Repositories\ContactInquiryRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

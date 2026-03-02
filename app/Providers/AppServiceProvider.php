<?php

namespace App\Providers;

use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.front', 'components.front.*'], function ($view) {
            $settings = app(SettingRepository::class)->getAll();
            $view->with('settings', $settings);
        });
    }
}

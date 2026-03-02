<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CertificationController as AdminCertificationController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SortController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TrackRecordController as AdminTrackRecordController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\CertificationController;
use App\Http\Controllers\Front\ClientController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MenuController;
use App\Http\Controllers\Front\TrackRecordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/packages/{slug}', [MenuController::class, 'package'])->name('menu.package');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/track-record', [TrackRecordController::class, 'index'])->name('track-record');
Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications');
Route::get('/clients', [ClientController::class, 'index'])->name('clients');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Authenticated routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Hero Slides
        Route::resource('hero-slides', HeroController::class);

        // Menus & Menu Items
        Route::resource('menus', AdminMenuController::class);
        Route::resource('menus.items', MenuItemController::class);

        // Packages
        Route::resource('packages', PackageController::class);

        // Gallery
        Route::resource('gallery', AdminGalleryController::class);
        Route::resource('gallery-categories', GalleryCategoryController::class);

        // Clients
        Route::resource('clients', AdminClientController::class);

        // Certifications
        Route::resource('certifications', AdminCertificationController::class);

        // Track Records
        Route::resource('track-records', AdminTrackRecordController::class);

        // Team
        Route::resource('team', TeamController::class);

        // Inquiries
        Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');

        // Sort (drag-to-reorder)
        Route::post('/sort', [SortController::class, 'update'])->name('sort.update');
    });
});

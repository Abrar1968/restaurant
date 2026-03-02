<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Client;
use App\Models\ContactInquiry;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\TeamMember;
use App\Models\TrackRecord;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 MenuItems for each cuisine
        Menu::all()->each(function (Menu $menu) {
            MenuItem::factory(5)->create(['menu_id' => $menu->id]);
        });

        // 2 Packages with 3 PackageItems each
        Package::factory(2)->create()->each(function (Package $package) {
            PackageItem::factory(3)->create(['package_id' => $package->id]);
        });

        // 3 GalleryCategories with 4 GalleryImages each
        GalleryCategory::factory(3)->create()->each(function (GalleryCategory $category) {
            GalleryImage::factory(4)->create(['gallery_category_id' => $category->id]);
        });

        // 10 Clients
        Client::factory(10)->create();

        // 3 Certifications
        Certification::factory(3)->create();

        // 5 TrackRecords
        TrackRecord::factory(5)->create();

        // 3 TeamMembers
        TeamMember::factory(3)->create();

        // 5 ContactInquiries
        ContactInquiry::factory(5)->create();
    }
}

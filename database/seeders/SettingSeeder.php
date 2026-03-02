<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'Sanjung Delights',
            'tagline' => 'Premier Halal Corporate Catering',
            'phone_1' => '+603-7960 5366',
            'phone_2' => '+603-7960 5367',
            'email_1' => 'sales@sanjungwaja.com',
            'email_2' => 'info@sanjungwaja.com',
            'whatsapp_number' => '60179605366',
            'address' => 'No. 27, Jalan SS 4d/14, Taman Midah, 47301 Petaling Jaya, Selangor',
            'business_hours' => 'MON-FRI 9:00AM - 6:00PM | SAT 9:00AM - 1:00PM',
            'google_maps_embed' => '',
            'sst_notice' => 'All prices are subject to 8% SST.',
            'copyright_text' => '© 2026 Sanjung Delights. All Rights Reserved.',
            'hero_headline' => 'Halal Corporate Catering in KL & Klang Valley',
            'hero_subtext' => 'Fantastic Food, Business Class Service',
            'about_text' => 'Sanjung Delights is the catering arm of Sanjung Waja Resources, established in 2010...',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'page' => 'home',
                'headline' => 'Halal Corporate Catering in KL & Klang Valley',
                'subheadline' => 'Fantastic Food, Business Class Service',
                'cta_text' => 'View Menu',
                'cta_url' => '/menu',
                'sort_order' => 1,
            ],
            [
                'page' => 'about',
                'headline' => 'Our Story',
                'subheadline' => 'Established in 2010, delivering excellence in halal catering.',
                'cta_text' => 'Learn More',
                'cta_url' => '#about-content',
                'sort_order' => 1,
            ],
            [
                'page' => 'menu',
                'headline' => 'Our Menus',
                'subheadline' => 'Explore our diverse range of Malay, Chinese, Indian & Western cuisines.',
                'cta_text' => 'Explore',
                'cta_url' => '#menu-list',
                'sort_order' => 1,
            ],
            [
                'page' => 'gallery',
                'headline' => 'Gallery',
                'subheadline' => 'A glimpse into our events, food presentations and setups.',
                'cta_text' => 'Explore',
                'cta_url' => '#gallery-grid',
                'sort_order' => 1,
            ],
            [
                'page' => 'contact',
                'headline' => 'Get In Touch',
                'subheadline' => 'Let us cater your next corporate event.',
                'cta_text' => 'Contact Us',
                'cta_url' => '#contact-form',
                'sort_order' => 1,
            ],
            [
                'page' => 'certifications',
                'headline' => 'Our Certifications',
                'subheadline' => 'Certified halal and food-safety compliant for your peace of mind.',
                'cta_text' => 'Learn More',
                'cta_url' => '#certifications-list',
                'sort_order' => 1,
            ],
            [
                'page' => 'track-record',
                'headline' => 'Track Record',
                'subheadline' => 'Over a decade of trusted catering service across Malaysia.',
                'cta_text' => 'Explore',
                'cta_url' => '#track-record-list',
                'sort_order' => 1,
            ],
            [
                'page' => 'clients',
                'headline' => 'Our Clients',
                'subheadline' => 'Trusted by leading corporations, institutions and government bodies.',
                'cta_text' => 'View All',
                'cta_url' => '#clients-list',
                'sort_order' => 1,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::query()->firstOrCreate(
                ['page' => $slide['page'], 'sort_order' => $slide['sort_order']],
                array_merge($slide, ['is_active' => true])
            );
        }
    }
}

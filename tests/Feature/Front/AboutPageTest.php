<?php

use App\Models\HeroSlide;

test('about page loads successfully', function () {
    $this->get(route('about'))->assertOk();
});

test('about page displays hero from database', function () {
    $hero = HeroSlide::factory()->create([
        'page' => 'about',
        'headline' => 'About Us Hero Test',
        'is_active' => true,
    ]);

    $this->get(route('about'))
        ->assertOk()
        ->assertSee('About Us Hero Test');
});

<?php

use App\Models\Client;
use App\Models\HeroSlide;
use App\Models\Menu;

test('home page loads successfully', function () {
    $this->get(route('home'))->assertOk();
});

test('home page displays hero headline from database', function () {
    $hero = HeroSlide::factory()->create([
        'page' => 'home',
        'headline' => 'Test Hero Headline',
        'is_active' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Test Hero Headline');
});

test('home page displays active menus', function () {
    $menu = Menu::factory()->create([
        'name' => 'Malay Cuisine Test',
        'slug' => 'malay-test',
        'is_active' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Malay Cuisine Test');
});

test('home page displays client logos in marquee', function () {
    $client = Client::factory()->create([
        'name' => 'Test Corp',
        'logo_path' => 'clients/test-logo.png',
        'show_in_marquee' => true,
        'is_active' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Test Corp');
});

test('home page does not show inactive menus', function () {
    $menu = Menu::factory()->create([
        'name' => 'Hidden Menu',
        'slug' => 'hidden-menu',
        'cuisine_type' => 'other',
        'is_active' => false,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Hidden Menu');
});

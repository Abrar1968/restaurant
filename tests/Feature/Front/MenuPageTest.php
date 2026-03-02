<?php

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Package;

test('menu index page loads successfully', function () {
    $this->get(route('menu'))->assertOk();
});

test('menu index displays active cuisines', function () {
    $menu = Menu::factory()->create([
        'name' => 'Chinese Test Cuisine',
        'slug' => 'chinese-test',
        'is_active' => true,
    ]);

    $this->get(route('menu'))
        ->assertOk()
        ->assertSee('Chinese Test Cuisine');
});

test('menu show page loads with valid slug', function () {
    $menu = Menu::factory()->create([
        'slug' => 'test-cuisine',
        'is_active' => true,
    ]);

    $this->get(route('menu.show', 'test-cuisine'))
        ->assertOk();
});

test('menu show page returns 404 for invalid slug', function () {
    $this->get(route('menu.show', 'nonexistent-menu'))
        ->assertNotFound();
});

test('menu show page displays menu items grouped by category', function () {
    $menu = Menu::factory()->create([
        'slug' => 'grouped-test',
        'is_active' => true,
    ]);

    $category = MenuCategory::factory()->create([
        'menu_id' => $menu->id,
        'name' => 'Test Category',
    ]);

    $category2 = MenuCategory::factory()->create([
        'menu_id' => $menu->id,
        'name' => 'Second Category',
    ]);

    $item = MenuItem::factory()->create([
        'menu_id' => $menu->id,
        'menu_category_id' => $category->id,
        'name' => 'Test Dish Item',
        'is_available' => true,
    ]);

    $this->get(route('menu.show', 'grouped-test'))
        ->assertOk()
        ->assertSee('Test Category')
        ->assertSee('Test Dish Item');
});

test('package page loads with valid slug', function () {
    $package = Package::factory()->create([
        'slug' => 'test-package',
        'is_active' => true,
    ]);

    $this->get(route('menu.package', 'test-package'))
        ->assertOk();
});

test('package page returns 404 for invalid slug', function () {
    $this->get(route('menu.package', 'nonexistent-package'))
        ->assertNotFound();
});

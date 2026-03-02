<?php

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

test('admin can view menus index', function () {
    Menu::factory()->count(3)->create();

    $this->get(route('admin.menus.index'))
        ->assertOk();
});

test('admin can view menu create form', function () {
    $this->get(route('admin.menus.create'))
        ->assertOk();
});

test('admin can create a menu', function () {
    $data = [
        'name' => 'New Test Menu',
        'slug' => 'new-test-menu',
        'cuisine_type' => 'malay',
        'description' => 'A test menu',
        'sort_order' => 0,
        'is_active' => true,
    ];

    $this->post(route('admin.menus.store'), $data)
        ->assertRedirect(route('admin.menus.index'));

    $this->assertDatabaseHas('menus', ['slug' => 'new-test-menu']);
});

test('admin can edit a menu', function () {
    $menu = Menu::factory()->create();

    $this->get(route('admin.menus.edit', $menu))
        ->assertOk();
});

test('admin can update a menu', function () {
    $menu = Menu::factory()->create();

    $this->put(route('admin.menus.update', $menu), [
        'name' => 'Updated Menu',
        'slug' => $menu->slug,
        'cuisine_type' => 'chinese',
        'description' => 'Updated',
        'sort_order' => 1,
        'is_active' => true,
    ])->assertRedirect(route('admin.menus.index'));

    $this->assertDatabaseHas('menus', [
        'id' => $menu->id,
        'name' => 'Updated Menu',
    ]);
});

test('admin can delete a menu', function () {
    $menu = Menu::factory()->create();

    $this->delete(route('admin.menus.destroy', $menu))
        ->assertRedirect(route('admin.menus.index'));

    $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
});

test('admin can view menu items index', function () {
    $menu = Menu::factory()->create();

    $this->get(route('admin.menus.items.index', $menu))
        ->assertOk();
});

test('admin can create a menu item', function () {
    $menu = Menu::factory()->create();
    $category = MenuCategory::factory()->create(['menu_id' => $menu->id]);

    $data = [
        'name' => 'Test Item',
        'menu_category_id' => $category->id,
        'is_available' => true,
        'is_halal' => true,
        'sort_order' => 0,
    ];

    $this->post(route('admin.menus.items.store', $menu), $data)
        ->assertRedirect(route('admin.menus.items.index', $menu));

    $this->assertDatabaseHas('menu_items', [
        'name' => 'Test Item',
        'menu_id' => $menu->id,
    ]);
});

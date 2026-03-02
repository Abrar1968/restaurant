<?php

use App\Models\GalleryCategory;
use App\Models\GalleryImage;

test('gallery page loads successfully', function () {
    $this->get(route('gallery'))->assertOk();
});

test('gallery page displays categories', function () {
    $category = GalleryCategory::factory()->create(['name' => 'Test Gallery Cat']);

    $this->get(route('gallery'))
        ->assertOk()
        ->assertSee('Test Gallery Cat');
});

test('gallery page displays images', function () {
    $category = GalleryCategory::factory()->create();
    $image = GalleryImage::factory()->create([
        'gallery_category_id' => $category->id,
        'caption' => 'Test Gallery Photo',
        'is_active' => true,
    ]);

    $this->get(route('gallery'))
        ->assertOk()
        ->assertSee('Test Gallery Photo');
});

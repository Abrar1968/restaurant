<?php

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

test('admin can view gallery index', function () {
    $this->get(route('admin.gallery.index'))
        ->assertOk();
});

test('admin can view gallery create form', function () {
    $this->get(route('admin.gallery.create'))
        ->assertOk();
});

test('admin can delete a gallery image', function () {
    $category = GalleryCategory::factory()->create();
    $image = GalleryImage::factory()->create([
        'gallery_category_id' => $category->id,
    ]);

    $this->delete(route('admin.gallery.destroy', $image))
        ->assertRedirect(route('admin.gallery.index'));

    $this->assertDatabaseMissing('gallery_images', ['id' => $image->id]);
});

test('admin can view gallery categories index', function () {
    $this->get(route('admin.gallery-categories.index'))
        ->assertOk();
});

test('admin can create a gallery category', function () {
    $this->post(route('admin.gallery-categories.store'), [
        'name' => 'Test Category',
        'slug' => 'test-category',
        'sort_order' => 0,
    ])->assertRedirect(route('admin.gallery-categories.index'));

    $this->assertDatabaseHas('gallery_categories', ['slug' => 'test-category']);
});

<?php

use App\Models\HeroSlide;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

test('admin can view hero slides index', function () {
    HeroSlide::factory()->count(3)->create();

    $this->get(route('admin.hero-slides.index'))
        ->assertOk();
});

test('admin can view hero slide create form', function () {
    $this->get(route('admin.hero-slides.create'))
        ->assertOk();
});

test('admin can create a hero slide', function () {
    $data = [
        'page' => 'home',
        'headline' => 'New Hero Slide',
        'subheadline' => 'Test subheadline',
        'cta_text' => 'Learn More',
        'cta_url' => '/about',
        'sort_order' => 0,
        'is_active' => true,
    ];

    $this->post(route('admin.hero-slides.store'), $data)
        ->assertRedirect(route('admin.hero-slides.index'));

    $this->assertDatabaseHas('hero_slides', [
        'headline' => 'New Hero Slide',
        'page' => 'home',
    ]);
});

test('admin can edit a hero slide', function () {
    $slide = HeroSlide::factory()->create();

    $this->get(route('admin.hero-slides.edit', $slide))
        ->assertOk();
});

test('admin can update a hero slide', function () {
    $slide = HeroSlide::factory()->create();

    $this->put(route('admin.hero-slides.update', $slide), [
        'page' => $slide->page,
        'headline' => 'Updated Headline',
        'subheadline' => 'Updated sub',
        'sort_order' => 0,
        'is_active' => true,
    ])->assertRedirect(route('admin.hero-slides.index'));

    $this->assertDatabaseHas('hero_slides', [
        'id' => $slide->id,
        'headline' => 'Updated Headline',
    ]);
});

test('admin can delete a hero slide', function () {
    $slide = HeroSlide::factory()->create();

    $this->delete(route('admin.hero-slides.destroy', $slide))
        ->assertRedirect(route('admin.hero-slides.index'));

    $this->assertDatabaseMissing('hero_slides', ['id' => $slide->id]);
});

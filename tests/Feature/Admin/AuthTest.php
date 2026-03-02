<?php

use App\Models\User;

test('admin login page loads successfully', function () {
    $this->get(route('admin.login'))->assertOk();
});

test('admin can login with valid credentials', function () {
    $admin = User::factory()->create([
        'email' => 'test@admin.com',
        'password' => bcrypt('testpassword'),
    ]);

    $this->post(route('admin.login.post'), [
        'email' => 'test@admin.com',
        'password' => 'testpassword',
    ])->assertRedirect(route('admin.dashboard'));
});

test('admin login rejects invalid credentials', function () {
    $this->post(route('admin.login.post'), [
        'email' => 'wrong@admin.com',
        'password' => 'wrongpassword',
    ])->assertSessionHasErrors();
});

test('unauthenticated user is redirected to login from dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));
});

test('authenticated admin can access dashboard', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

test('admin can logout', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));
});

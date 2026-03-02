<?php

use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

test('admin can view settings page', function () {
    $this->get(route('admin.settings'))
        ->assertOk();
});

test('admin can update settings', function () {
    Setting::query()->create(['key' => 'site_name', 'value' => 'Old Name']);

    $this->post(route('admin.settings.update'), [
        'site_name' => 'Updated Site Name',
        'phone_1' => '+60162204535',
    ])->assertRedirect(route('admin.settings'));
});

<?php

use App\Models\Certification;

test('certifications page loads successfully', function () {
    $this->get(route('certifications'))->assertOk();
});

test('certifications page displays active certifications', function () {
    $cert = Certification::factory()->create([
        'name' => 'Test Halal Cert',
        'issuing_body' => 'Test Body',
        'is_active' => true,
    ]);

    $this->get(route('certifications'))
        ->assertOk()
        ->assertSee('Test Halal Cert')
        ->assertSee('Test Body');
});

<?php

test('contact page loads successfully', function () {
    $this->get(route('contact'))->assertOk();
});

test('contact form submission creates inquiry', function () {
    $data = [
        'name' => 'John Doe',
        'company' => 'Test Company',
        'email' => 'john@test.com',
        'phone' => '+60123456789',
        'event_type' => 'Corporate Meeting',
        'expected_guests' => 100,
        'event_date' => now()->addDays(30)->toDateString(),
        'message' => 'We need catering for a corporate event.',
    ];

    $this->post(route('contact.submit'), $data)
        ->assertRedirect();

    $this->assertDatabaseHas('contact_inquiries', [
        'email' => 'john@test.com',
        'company' => 'Test Company',
    ]);
});

test('contact form validation rejects missing required fields', function () {
    $this->post(route('contact.submit'), [])
        ->assertSessionHasErrors(['name', 'email', 'message']);
});

test('contact form validation rejects invalid email', function () {
    $this->post(route('contact.submit'), [
        'name' => 'Test',
        'email' => 'not-an-email',
        'message' => 'Hello',
    ])
        ->assertSessionHasErrors(['email']);
});

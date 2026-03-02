<?php

use App\Models\Client;

test('clients page loads successfully', function () {
    $this->get(route('clients'))->assertOk();
});

test('clients page displays active clients', function () {
    $client = Client::factory()->create([
        'name' => 'Test Corp Client',
        'show_in_clients_page' => true,
        'is_active' => true,
    ]);

    $this->get(route('clients'))
        ->assertOk()
        ->assertSee('Test Corp Client');
});

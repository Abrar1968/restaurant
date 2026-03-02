<?php

use App\Models\Client;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

test('admin can view clients index', function () {
    Client::factory()->count(3)->create();

    $this->get(route('admin.clients.index'))
        ->assertOk();
});

test('admin can view client create form', function () {
    $this->get(route('admin.clients.create'))
        ->assertOk();
});

test('admin can create a client', function () {
    $data = [
        'name' => 'New Client Corp',
        'sector' => 'corp',
        'show_in_marquee' => true,
        'show_in_clients_page' => true,
        'sort_order' => 0,
        'is_active' => true,
    ];

    $this->post(route('admin.clients.store'), $data)
        ->assertRedirect(route('admin.clients.index'));

    $this->assertDatabaseHas('clients', ['name' => 'New Client Corp']);
});

test('admin can update a client', function () {
    $client = Client::factory()->create();

    $this->put(route('admin.clients.update', $client), [
        'name' => 'Updated Client',
        'sector' => 'industrial',
        'show_in_marquee' => true,
        'show_in_clients_page' => true,
        'sort_order' => 0,
        'is_active' => true,
    ])->assertRedirect(route('admin.clients.index'));

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'name' => 'Updated Client',
    ]);
});

test('admin can delete a client', function () {
    $client = Client::factory()->create();

    $this->delete(route('admin.clients.destroy', $client))
        ->assertRedirect(route('admin.clients.index'));

    $this->assertDatabaseMissing('clients', ['id' => $client->id]);
});

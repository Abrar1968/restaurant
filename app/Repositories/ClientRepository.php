<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository
{
    /**
     * Get active clients shown in the marquee section.
     */
    public function getMarqueeClients(): Collection
    {
        return Client::query()
            ->where('show_in_marquee', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get active clients shown on the clients page.
     */
    public function getClientsPageClients(): Collection
    {
        return Client::query()
            ->where('show_in_clients_page', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all clients ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return Client::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a client by ID or throw an exception.
     */
    public function findOrFail(int $id): Client
    {
        return Client::query()->findOrFail($id);
    }

    /**
     * Create a new client.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Client
    {
        return Client::query()->create($data);
    }

    /**
     * Update an existing client.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Client
    {
        $client = Client::query()->findOrFail($id);
        $client->update($data);

        return $client;
    }

    /**
     * Delete a client.
     */
    public function delete(int $id): void
    {
        $client = Client::query()->findOrFail($id);
        $client->delete();
    }
}

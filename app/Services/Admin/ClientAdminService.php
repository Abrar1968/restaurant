<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class ClientAdminService
{
    public function __construct(
        protected ClientRepository $clientRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    /**
     * Get all clients ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return $this->clientRepo->getAll();
    }

    /**
     * Find a client by ID.
     */
    public function find(int $id): Client
    {
        return $this->clientRepo->findOrFail($id);
    }

    /**
     * Create a new client with optional logo upload.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $logo = null): Client
    {
        if ($logo) {
            $data['logo_path'] = $this->imageUploadService->upload($logo, 'clients');
        }

        return $this->clientRepo->create($data);
    }

    /**
     * Update a client with optional logo replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data, ?UploadedFile $logo = null): Client
    {
        if ($logo) {
            $client = $this->clientRepo->findOrFail($id);
            $data['logo_path'] = $this->imageUploadService->replace($client->logo_path, $logo, 'clients');
        }

        return $this->clientRepo->update($id, $data);
    }

    /**
     * Delete a client and its logo.
     */
    public function delete(int $id): void
    {
        $client = $this->clientRepo->findOrFail($id);
        $this->imageUploadService->delete($client->logo_path);
        $this->clientRepo->delete($id);
    }
}

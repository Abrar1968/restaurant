<?php

namespace App\Services\Front;

use App\Repositories\ClientRepository;
use App\Repositories\HeroRepository;
use App\Repositories\SettingRepository;

class ClientService
{
    public function __construct(
        protected HeroRepository $heroRepo,
        protected ClientRepository $clientRepo,
        protected SettingRepository $settingRepo,
    ) {}

    /**
     * Get all data needed for the clients page.
     *
     * @return array<string, mixed>
     */
    public function getClientData(): array
    {
        return [
            'hero' => $this->heroRepo->getActiveForPage('clients'),
            'clients' => $this->clientRepo->getClientsPageClients(),
            'settings' => $this->settingRepo->getAll(),
        ];
    }
}

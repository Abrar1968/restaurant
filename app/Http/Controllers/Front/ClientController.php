<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\ClientService;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct(protected ClientService $clientService) {}

    public function index(): View
    {
        return view('front.clients', $this->clientService->getClientData());
    }
}

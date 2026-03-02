<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Services\Admin\ClientAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct(protected ClientAdminService $clientAdminService)
    {
    }

    public function index(): View
    {
        return view('admin.clients.index', [
            'clients' => $this->clientAdminService->getAll(),
        ]);
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $this->clientAdminService->create(
            $request->validated(),
            $request->file('logo'),
        );

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.clients.edit', [
            'client' => $this->clientAdminService->findOrFail($id),
        ]);
    }

    public function update(StoreClientRequest $request, int $id): RedirectResponse
    {
        $this->clientAdminService->update(
            $id,
            $request->validated(),
            $request->file('logo'),
        );

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->clientAdminService->delete($id);

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\TeamAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct(protected TeamAdminService $teamAdminService)
    {
    }

    public function index(): View
    {
        return view('admin.team.index', [
            'members' => $this->teamAdminService->getAll(),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->teamAdminService->create(
            $request->all(),
            $request->file('photo'),
        );

        return redirect()->route('admin.team.index')->with('success', 'Team member created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.team.edit', [
            'member' => $this->teamAdminService->findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->teamAdminService->update(
            $id,
            $request->all(),
            $request->file('photo'),
        );

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->teamAdminService->delete($id);

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }
}

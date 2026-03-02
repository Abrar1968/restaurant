<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PackageAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function __construct(protected PackageAdminService $packageAdminService) {}

    public function index(): View
    {
        return view('admin.packages.index', [
            'packages' => $this->packageAdminService->getAll(),
        ]);
    }

    public function create(): View
    {
        return view('admin.packages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->packageAdminService->create(
            $request->all(),
            $request->file('image'),
        );

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.packages.edit', [
            'package' => $this->packageAdminService->findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->packageAdminService->update(
            $id,
            $request->all(),
            $request->file('image'),
        );

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->packageAdminService->delete($id);

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuRequest;
use App\Services\Admin\MenuAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __construct(protected MenuAdminService $menuAdminService) {}

    public function index(): View
    {
        return view('admin.menus.index', [
            'menus' => $this->menuAdminService->getAllMenus(),
        ]);
    }

    public function create(): View
    {
        return view('admin.menus.create');
    }

    public function store(StoreMenuRequest $request): RedirectResponse
    {
        $this->menuAdminService->createMenu(
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(int $id): View
    {
        return view('admin.menus.edit', [
            'menu' => $this->menuAdminService->findMenuOrFail($id),
        ]);
    }

    public function update(StoreMenuRequest $request, int $id): RedirectResponse
    {
        $this->menuAdminService->updateMenu(
            $id,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->menuAdminService->deleteMenu($id);

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuItemRequest;
use App\Services\Admin\MenuAdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function __construct(protected MenuAdminService $menuAdminService) {}

    public function index(int $menuId): View
    {
        return view('admin.menu-items.index', [
            'menu' => $this->menuAdminService->findMenuOrFail($menuId),
            'items' => $this->menuAdminService->getMenuItems($menuId),
            'menus' => $this->menuAdminService->getAllMenus(),
        ]);
    }

    public function create(int $menuId): View
    {
        return view('admin.menu-items.create', [
            'menu' => $this->menuAdminService->findMenuOrFail($menuId),
        ]);
    }

    public function store(StoreMenuItemRequest $request, int $menuId): RedirectResponse
    {
        $this->menuAdminService->createMenuItem(
            $menuId,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.menus.items.index', $menuId)->with('success', 'Menu item created successfully.');
    }

    public function edit(int $menuId, int $itemId): View
    {
        return view('admin.menu-items.edit', [
            'menu' => $this->menuAdminService->findMenuOrFail($menuId),
            'item' => $this->menuAdminService->findMenuItemOrFail($itemId),
        ]);
    }

    public function update(StoreMenuItemRequest $request, int $menuId, int $itemId): RedirectResponse
    {
        $this->menuAdminService->updateMenuItem(
            $itemId,
            $request->validated(),
            $request->file('image'),
        );

        return redirect()->route('admin.menus.items.index', $menuId)->with('success', 'Menu item updated successfully.');
    }

    public function destroy(int $menuId, int $itemId): RedirectResponse
    {
        $this->menuAdminService->deleteMenuItem($itemId);

        return redirect()->route('admin.menus.items.index', $menuId)->with('success', 'Menu item deleted successfully.');
    }
}

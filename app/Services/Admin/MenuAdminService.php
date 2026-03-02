<?php

namespace App\Services\Admin;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Repositories\MenuCategoryRepository;
use App\Repositories\MenuItemRepository;
use App\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class MenuAdminService
{
    public function __construct(
        protected MenuRepository $menuRepo,
        protected MenuCategoryRepository $menuCategoryRepo,
        protected MenuItemRepository $menuItemRepo,
        protected ImageUploadService $imageUploadService,
    ) {}

    // ──────────────────────────────────────────────
    // Menus
    // ──────────────────────────────────────────────

    /**
     * Get all menus ordered by sort_order.
     */
    public function getAllMenus(): Collection
    {
        return $this->menuRepo->getAll();
    }

    /**
     * Find a menu by ID.
     */
    public function findMenu(int $id): Menu
    {
        return Menu::query()->with(['categories', 'items'])->findOrFail($id);
    }

    /**
     * Find a menu by ID or fail (alias).
     */
    public function findMenuOrFail(int $id): Menu
    {
        return $this->findMenu($id);
    }

    /**
     * Create a new menu with optional cover image.
     *
     * @param  array<string, mixed>  $data
     */
    public function createMenu(array $data, ?UploadedFile $image = null): Menu
    {
        if ($image) {
            $data['cover_image_path'] = $this->imageUploadService->upload($image, 'menus');
        }

        return $this->menuRepo->create($data);
    }

    /**
     * Update a menu with optional cover image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateMenu(int $id, array $data, ?UploadedFile $image = null): Menu
    {
        if ($image) {
            $menu = Menu::query()->findOrFail($id);
            $data['cover_image_path'] = $this->imageUploadService->replace($menu->cover_image_path, $image, 'menus');
        }

        return $this->menuRepo->update($id, $data);
    }

    /**
     * Delete a menu and its cover image.
     */
    public function deleteMenu(int $id): void
    {
        $menu = Menu::query()->findOrFail($id);
        $this->imageUploadService->delete($menu->cover_image_path);
        $this->menuRepo->delete($id);
    }

    // ──────────────────────────────────────────────
    // Categories
    // ──────────────────────────────────────────────

    /**
     * Get all categories for a specific menu.
     */
    public function getCategoriesForMenu(int $menuId): Collection
    {
        return $this->menuCategoryRepo->getForMenu($menuId);
    }

    /**
     * Find a menu category by ID.
     */
    public function findCategory(int $id): MenuCategory
    {
        return $this->menuCategoryRepo->findOrFail($id);
    }

    /**
     * Create a new menu category.
     *
     * @param  array<string, mixed>  $data
     */
    public function createCategory(array $data): MenuCategory
    {
        return $this->menuCategoryRepo->create($data);
    }

    /**
     * Update a menu category.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateCategory(int $id, array $data): MenuCategory
    {
        return $this->menuCategoryRepo->update($id, $data);
    }

    /**
     * Delete a menu category.
     */
    public function deleteCategory(int $id): void
    {
        $this->menuCategoryRepo->delete($id);
    }

    // ──────────────────────────────────────────────
    // Items
    // ──────────────────────────────────────────────

    /**
     * Get all items for a specific category.
     */
    public function getItemsForCategory(int $categoryId): Collection
    {
        return $this->menuItemRepo->getForCategory($categoryId);
    }

    /**
     * Find a menu item by ID.
     */
    public function findItem(int $id): MenuItem
    {
        return $this->menuItemRepo->findOrFail($id);
    }

    /**
     * Find a menu item by ID or fail (alias).
     */
    public function findMenuItemOrFail(int $id): MenuItem
    {
        return $this->findItem($id);
    }

    /**
     * Get all items for a specific menu.
     */
    public function getMenuItems(int $menuId): Collection
    {
        return $this->menuItemRepo->getForMenu($menuId);
    }

    /**
     * Create a new menu item with optional image.
     *
     * @param  array<string, mixed>  $data
     */
    public function createItem(array $data, ?UploadedFile $image = null): MenuItem
    {
        if ($image) {
            $data['image_path'] = $this->imageUploadService->upload($image, 'menu-items');
        }

        return $this->menuItemRepo->create($data);
    }

    /**
     * Create a new menu item (alias for controllers).
     *
     * @param  array<string, mixed>  $data
     */
    public function createMenuItem(int $menuId, array $data, ?UploadedFile $image = null): MenuItem
    {
        $data['menu_id'] = $menuId;

        return $this->createItem($data, $image);
    }

    /**
     * Update a menu item with optional image replacement.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateItem(int $id, array $data, ?UploadedFile $image = null): MenuItem
    {
        if ($image) {
            $item = $this->menuItemRepo->findOrFail($id);
            $data['image_path'] = $this->imageUploadService->replace($item->image_path, $image, 'menu-items');
        }

        return $this->menuItemRepo->update($id, $data);
    }

    /**
     * Update a menu item (alias for controllers).
     *
     * @param  array<string, mixed>  $data
     */
    public function updateMenuItem(int $id, array $data, ?UploadedFile $image = null): MenuItem
    {
        return $this->updateItem($id, $data, $image);
    }

    /**
     * Delete a menu item and its image.
     */
    public function deleteItem(int $id): void
    {
        $item = $this->menuItemRepo->findOrFail($id);
        $this->imageUploadService->delete($item->image_path);
        $this->menuItemRepo->delete($id);
    }

    /**
     * Delete a menu item (alias for controllers).
     */
    public function deleteMenuItem(int $id): void
    {
        $this->deleteItem($id);
    }
}

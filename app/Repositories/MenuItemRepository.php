<?php

namespace App\Repositories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;

class MenuItemRepository
{
    /**
     * Get all items for a specific menu, ordered by sort_order.
     */
    public function getForMenu(int $menuId): Collection
    {
        return MenuItem::query()
            ->where('menu_id', $menuId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all items for a specific category, ordered by sort_order.
     */
    public function getForCategory(int $categoryId): Collection
    {
        return MenuItem::query()
            ->where('menu_category_id', $categoryId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a menu item by ID or throw an exception.
     */
    public function findOrFail(int $id): MenuItem
    {
        return MenuItem::query()->findOrFail($id);
    }

    /**
     * Create a new menu item.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): MenuItem
    {
        return MenuItem::query()->create($data);
    }

    /**
     * Update an existing menu item.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): MenuItem
    {
        $item = MenuItem::query()->findOrFail($id);
        $item->update($data);

        return $item;
    }

    /**
     * Delete a menu item.
     */
    public function delete(int $id): void
    {
        $item = MenuItem::query()->findOrFail($id);
        $item->delete();
    }
}

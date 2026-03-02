<?php

namespace App\Repositories;

use App\Models\MenuCategory;
use Illuminate\Database\Eloquent\Collection;

class MenuCategoryRepository
{
    /**
     * Get all categories for a specific menu, ordered by sort_order.
     */
    public function getForMenu(int $menuId): Collection
    {
        return MenuCategory::query()
            ->where('menu_id', $menuId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a menu category by ID or throw an exception.
     */
    public function findOrFail(int $id): MenuCategory
    {
        return MenuCategory::query()->findOrFail($id);
    }

    /**
     * Create a new menu category.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): MenuCategory
    {
        return MenuCategory::query()->create($data);
    }

    /**
     * Update an existing menu category.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): MenuCategory
    {
        $category = MenuCategory::query()->findOrFail($id);
        $category->update($data);

        return $category;
    }

    /**
     * Delete a menu category.
     */
    public function delete(int $id): void
    {
        $category = MenuCategory::query()->findOrFail($id);
        $category->delete();
    }
}

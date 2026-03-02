<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository
{
    /**
     * Get all active cuisines (menus), ordered by sort_order.
     */
    public function getActiveCuisines(): Collection
    {
        return Menu::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Find a menu by slug with eager loaded categories and items.
     */
    public function findBySlug(string $slug): Menu
    {
        return Menu::query()
            ->with(['categories' => fn ($q) => $q->orderBy('sort_order'), 'categories.items' => fn ($q) => $q->orderBy('sort_order')])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * Get all menus ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return Menu::query()
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Create a new menu.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Menu
    {
        return Menu::query()->create($data);
    }

    /**
     * Update an existing menu.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): Menu
    {
        $menu = Menu::query()->findOrFail($id);
        $menu->update($data);

        return $menu;
    }

    /**
     * Delete a menu.
     */
    public function delete(int $id): void
    {
        $menu = Menu::query()->findOrFail($id);
        $menu->delete();
    }
}

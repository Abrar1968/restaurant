<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory(),
            'menu_category_id' => null,
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 5, 150),
            'price_note' => fake()->optional()->randomElement(['per pax', 'per tray', 'minimum 10 pax']),
            'image_path' => null,
            'tags' => fake()->optional()->randomElements(['vegetarian', 'spicy', 'signature', 'chef-recommend'], 2),
            'is_halal' => true,
            'is_available' => true,
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}

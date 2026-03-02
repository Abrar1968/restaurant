<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Malay Cuisine', 'Chinese Cuisine', 'Indian Cuisine', 'Western Cuisine']),
            'slug' => fn (array $attrs) => Str::slug($attrs['name']),
            'cuisine_type' => fn (array $attrs) => strtolower(explode(' ', $attrs['name'])[0]),
            'description' => fake()->paragraph(3),
            'cover_image_path' => null,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

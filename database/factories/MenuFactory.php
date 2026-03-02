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
        $name = fake()->unique()->randomElement(['Malay Cuisine', 'Chinese Cuisine', 'Indian Cuisine', 'Western Cuisine', 'Japanese Cuisine', 'Thai Cuisine']);
        $cuisineMap = [
            'malay' => 'malay', 'chinese' => 'chinese', 'indian' => 'indian',
            'western' => 'western', 'japanese' => 'other', 'thai' => 'other',
        ];
        $firstWord = strtolower(explode(' ', $name)[0]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'cuisine_type' => $cuisineMap[$firstWord] ?? 'other',
            'description' => fake()->paragraph(3),
            'cover_image_path' => null,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

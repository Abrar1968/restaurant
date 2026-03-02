<?php

namespace Database\Factories;

use App\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<GalleryCategory>
 */
class GalleryCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Events', 'Food', 'Setup', 'Team', 'Certificates']),
            'slug' => fn (array $attrs) => Str::slug($attrs['name']),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

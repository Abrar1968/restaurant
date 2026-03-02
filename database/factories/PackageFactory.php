<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['CNY 2026 Package', 'Christmas 2025 Package', 'Hari Raya Package', 'Corporate Meeting Package']),
            'slug' => fn (array $attrs) => Str::slug($attrs['name']),
            'tagline' => fake()->sentence(8),
            'description' => fake()->paragraphs(3, true),
            'cover_image_path' => null,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

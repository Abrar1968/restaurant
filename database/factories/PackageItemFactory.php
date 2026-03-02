<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PackageItem>
 */
class PackageItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'package_id' => Package::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 500),
            'price_label' => fake()->optional()->randomElement(['Per Person', 'Per Table', 'Per Set']),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

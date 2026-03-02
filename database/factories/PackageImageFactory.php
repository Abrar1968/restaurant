<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\PackageImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PackageImage>
 */
class PackageImageFactory extends Factory
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
            'image_path' => null,
            'caption' => fake()->optional()->sentence(4),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}

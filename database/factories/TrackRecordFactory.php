<?php

namespace Database\Factories;

use App\Models\TrackRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackRecord>
 */
class TrackRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => fake()->numberBetween(2010, 2026),
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(2),
            'client_name' => fake()->optional()->company(),
            'image_path' => null,
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}

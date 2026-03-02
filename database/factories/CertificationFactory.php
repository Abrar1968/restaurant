<?php

namespace Database\Factories;

use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Halal Certificate', 'HACCP', 'ISO 22000', 'MeSTI']),
            'issuing_body' => fake()->randomElement(['JAKIM', 'SIRIM', 'Bureau Veritas']),
            'certificate_image_path' => null,
            'valid_from' => fake()->dateTimeBetween('-2 years', 'now'),
            'valid_until' => fake()->dateTimeBetween('now', '+3 years'),
            'description' => fake()->paragraph(),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}

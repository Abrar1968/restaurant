<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'logo_path' => null,
            'sector' => fake()->randomElement(['corporate', 'education', 'government', 'industrial']),
            'show_in_marquee' => true,
            'show_in_clients_page' => true,
            'sort_order' => fake()->numberBetween(0, 50),
            'is_active' => true,
        ];
    }
}

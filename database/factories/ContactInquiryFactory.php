<?php

namespace Database\Factories;

use App\Models\ContactInquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactInquiry>
 */
class ContactInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->optional()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'event_type' => fake()->randomElement(['Corporate Meeting', 'Conference / Seminar', 'Company Gathering', 'Other']),
            'expected_guests' => fake()->numberBetween(20, 500),
            'event_date' => fake()->dateTimeBetween('+1 week', '+6 months'),
            'message' => fake()->paragraphs(2, true),
            'status' => 'new',
        ];
    }
}

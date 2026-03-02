<?php

namespace Database\Factories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlide>
 */
class HeroSlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page' => fake()->randomElement(['home', 'about', 'menu', 'gallery', 'contact', 'certifications', 'track-record', 'clients']),
            'image_path' => null,
            'headline' => fake()->sentence(6),
            'subheadline' => fake()->sentence(12),
            'cta_text' => fake()->randomElement(['Learn More', 'View Menu', 'Contact Us', 'Explore']),
            'cta_url' => fake()->randomElement(['#', '/menu', '/contact', '/about']),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the hero slide is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the hero slide is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryImage>
 */
class GalleryImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gallery_category_id' => GalleryCategory::factory(),
            'image_path' => 'gallery/test-image-'.fake()->uuid().'.jpg',
            'caption' => fake()->optional()->sentence(4),
            'alt_text' => fake()->optional()->sentence(4),
            'sort_order' => fake()->numberBetween(0, 50),
            'is_active' => true,
        ];
    }
}

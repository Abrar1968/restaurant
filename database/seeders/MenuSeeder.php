<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuisines = [
            ['name' => 'Malay Cuisine', 'slug' => 'malay', 'cuisine_type' => 'malay', 'sort_order' => 1],
            ['name' => 'Chinese Cuisine', 'slug' => 'chinese', 'cuisine_type' => 'chinese', 'sort_order' => 2],
            ['name' => 'Indian Cuisine', 'slug' => 'indian', 'cuisine_type' => 'indian', 'sort_order' => 3],
            ['name' => 'Western Cuisine', 'slug' => 'western', 'cuisine_type' => 'western', 'sort_order' => 4],
        ];

        foreach ($cuisines as $cuisine) {
            Menu::query()->firstOrCreate(['slug' => $cuisine['slug']], array_merge($cuisine, [
                'description' => 'Explore our ' . $cuisine['name'] . ' offerings.',
                'is_active' => true,
            ]));
        }
    }
}

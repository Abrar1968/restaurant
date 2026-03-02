<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@sanjungdelights.com'],
            [
                'name' => 'Sanjung Admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}

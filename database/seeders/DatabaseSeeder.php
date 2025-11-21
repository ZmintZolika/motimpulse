<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    // Seed the application's database.

    public function run(): void
    {
        // Test User létrehozása
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Motivációs idézetek létrehozása
        $this->call([
            MotivationalQuoteSeeder::class,
        ]);
    }
}

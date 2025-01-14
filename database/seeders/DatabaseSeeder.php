<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Chame o InstructionSeeder e o SituationSeeder
        $this->call([
            InstructionSeeder::class,
            SituationSeeder::class,
            OccasionSeeder::class,
            EnterpriseSeeder::class,
            CivilStateSeeder::class,
            GenderSeeder::class,
            ColorSeeder::class,
        ]);
    }
}

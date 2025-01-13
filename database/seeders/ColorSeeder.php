<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Color::where('name', 'Preta')->first()) {
            Color::create([
                'name' => 'Preta'
            ]);
        }

        if (!Color::where('name', 'Parda')->first()) {
            Color::create([
                'name' => 'Parda'
            ]);
        }

        if (!Color::where('name', 'Amarela')->first()) {
            Color::create([
                'name' => 'Amarela'
            ]);
        }

        if (!Color::where('name', 'Indígena')->first()) {
            Color::create([
                'name' => 'Indígena'
            ]);
        }

        if (!Color::where('name', 'Branca')->first()) {
            Color::create([
                'name' => 'Branca'
            ]);
        }
    }
}

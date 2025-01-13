<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Gender::where('name', 'Masculino')->first()) {
            Gender::create([
                'name' => 'Masculino'
            ]);
        }

        if (!Gender::where('name', 'Feminino')->first()) {
            Gender::create([
                'name' => 'Feminino'
            ]);
        }

        if (!Gender::where('name', 'Intersexo')->first()) {
            Gender::create([
                'name' => 'Intersexo'
            ]);
        }
    }
}

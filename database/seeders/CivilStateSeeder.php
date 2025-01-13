<?php

namespace Database\Seeders;

use App\Models\CivilState;
use Illuminate\Database\Seeder;

class CivilStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!CivilState::where('name', 'Casado')->first()) {
            CivilState::create([
                'name' => 'Casado'
            ]);
        }

        if (!CivilState::where('name', 'Solteiro')->first()) {
            CivilState::create([
                'name' => 'Solteiro'
            ]);
        }

        if (!CivilState::where('name', 'Separado')->first()) {
            CivilState::create([
                'name' => 'Separado'
            ]);
        }

        if (!CivilState::where('name', 'Divorciado')->first()) {
            CivilState::create([
                'name' => 'Divorciado'
            ]);
        }

        if (!CivilState::where('name', 'Viúvo')->first()) {
            CivilState::create([
                'name' => 'Viúvo'
            ]);
        }
    }
}

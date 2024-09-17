<?php

namespace Database\Seeders;

use App\Models\Situation;
use Illuminate\Database\Seeder;

class SituationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Situation::where('name', 'Demissão')->first()) {
            Situation::create([
                'name' => 'Demissão',
                'color' => 'danger',
            ]);
        }

        if (!Situation::where('name', 'Encerrado')->first()) {
            Situation::create([
                'name' => 'Encerrado',
                'color' => 'warning',
            ]);
        }

        if (!Situation::where('name', 'Aprovado')->first()) {
            Situation::create([
                'name' => 'Aprovado',
                'color' => 'success',
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Occasion;
use Illuminate\Database\Seeder;

class OccasionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Occasion::where('name', 'Advertência')->first()) {
            Occasion::create([
                'name' => 'Advertência'
            ]);
        }

        if (!Occasion::where('name', 'Falta')->first()) {
            Occasion::create([
                'name' => 'Falta'
            ]);
        }

        if (!Occasion::where('name', 'Folga')->first()) {
            Occasion::create([
                'name' => 'Folga'
            ]);
        }
        
        if (!Occasion::where('name', 'Função')->first()) {
            Occasion::create([
                'name' => 'Função'
            ]);
        }

        if (!Occasion::where('name', 'Afastamento')->first()) {
            Occasion::create([
                'name' => 'Afastamento'
            ]);
        }

        if (!Occasion::where('name', 'Suspensão')->first()) {
            Occasion::create([
                'name' => 'Suspensão'
            ]);
        }
    }
}

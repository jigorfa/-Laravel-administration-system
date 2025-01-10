<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use Illuminate\Database\Seeder;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Enterprise::where('name', 'MT MOTO INDÚSTRIA EIRELE')->first()) {
            Enterprise::create([
                'name' => 'MT MOTO INDÚSTRIA EIRELE'
            ]);
        }

        if (!Enterprise::where('name', 'MT INDÚSTRIA PNEUS PEÇAS E ACESSÓRIOS LTDA')->first()) {
            Enterprise::create([
                'name' => 'MT INDÚSTRIA PNEUS PEÇAS E ACESSÓRIOS LTDA'
            ]);
        }

        if (!Enterprise::where('name', 'HS INDÚSTRIA E ACESSÓRIOS')->first()) {
            Enterprise::create([
                'name' => 'HS INDÚSTRIA E ACESSÓRIOS'
            ]);
        }
    }
}

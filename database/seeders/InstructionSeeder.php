<?php

namespace Database\Seeders;

use App\Models\Instruction;
use Illuminate\Database\Seeder;

class InstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Instruction::where('name', 'Fundamental Inc.')->first()) {
            Instruction::create([
                'name' => 'Fundamental Inc.'
            ]);
        }

        if (!Instruction::where('name', 'Fundamental Com.')->first()) {
            Instruction::create([
                'name' => 'Fundamental Com.'
            ]);
        }

        if (!Instruction::where('name', 'Médio Inc.')->first()) {
            Instruction::create([
                'name' => 'Médio Inc.'
            ]);
        }

        if (!Instruction::where('name', 'Médio Com.')->first()) {
            Instruction::create([
                'name' => 'Médio Com.'
            ]);
        }

        if (!Instruction::where('name', 'Superior')->first()) {
            Instruction::create([
                'name' => 'Superior'
            ]);
        }

        if (!Instruction::where('name', 'Mestrado')->first()) {
            Instruction::create([
                'name' => 'Mestrado'
            ]);
        }

        if (!Instruction::where('name', 'Doutorado')->first()) {
            Instruction::create([
                'name' => 'Doutorado'
            ]);
        }
    }
}

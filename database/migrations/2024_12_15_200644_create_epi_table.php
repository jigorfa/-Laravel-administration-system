<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('epi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_code'); // Chave estrangeira para a tabela 'employee'
            $table->foreign('employee_code')->references('code')->on('employee')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epi');
    }
};

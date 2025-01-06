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
        Schema::create('epi_detail', function (Blueprint $table) {
            $table->id(); // Coluna padrão de chave primária
            $table->unsignedBigInteger('epi_id');
            $table->foreign('epi_id')->references('id')->on('epi')->onDelete('cascade');
            $table->date('expedition_date'); // Data do atraso
            $table->text('name')->nullable(); // Hora de chegada
            $table->integer('quantity')->nullable(); // Hora de saída
            $table->string('description')->nullable(); // Motivo
            $table->timestamps(); // Datas de criação/atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epi_detail');
    }
};
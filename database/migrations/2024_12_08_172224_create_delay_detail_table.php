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
        Schema::create('delay_detail', function (Blueprint $table) {
            $table->id(); // Coluna padrão de chave primária
            $table->unsignedBigInteger('delay_id');
            $table->foreign('delay_id')->references('id')->on('delay')->onDelete('cascade');
            $table->date('delay_date'); // Data do atraso
            $table->time('arrival')->nullable(); // Hora de chegada
            $table->time('leave')->nullable(); // Hora de saída
            $table->string('description')->nullable(); // Motivo
            $table->timestamps(); // Datas de criação/atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delay_detail');
    }
};
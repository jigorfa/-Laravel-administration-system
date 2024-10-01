<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attest', function (Blueprint $table) {
            $table->id('code'); // Chave primária automática // Código único do atestado
            $table->string('name'); // Nome da pessoa
            $table->string('adjuntancy'); // Adjunto (campo opcional)
            $table->date('start_date'); // Data de início
            $table->date('end_date'); // Data de fim
            $table->integer('total_days')->nullable(); // Total de dias (campo opcional)
            $table->string('cause'); // Causa do atestado
            $table->string('annex');
            $table->timestamps(); // created_at e updated_at

            // Indexes podem ser adicionados aqui, se necessário
            // $table->index(['name', 'adjuntancy']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('attest');
    }
};

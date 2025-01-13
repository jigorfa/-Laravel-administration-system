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
            $table->id();
            $table->unsignedBigInteger('epi_id');
            $table->foreign('epi_id')->references('id')->on('epi')->onDelete('cascade');
            $table->date('expedition_date');
            $table->text('name')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
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
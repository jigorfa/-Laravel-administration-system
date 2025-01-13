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
        Schema::create('attest_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attest_id');
            $table->foreign('attest_id')->references('id')->on('attest')->onDelete('cascade');
            $table->date('start_attest')->nullable();
            $table->date('end_attest')->nullable();
            $table->integer('total_days')->nullable();
            $table->string('cause')->nullable();
            $table->string('annex')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attest_detail');
    }
};
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
            $table->id();
            $table->unsignedBigInteger('delay_id');
            $table->foreign('delay_id')->references('id')->on('delay')->onDelete('cascade');
            $table->date('delay_date');
            $table->time('arrival')->nullable();
            $table->time('leave')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
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
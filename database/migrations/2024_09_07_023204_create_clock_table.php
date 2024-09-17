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
        Schema::create('clock', function (Blueprint $table) {
            $table->id('code');
            $table->string('name');
            $table->string('adjuntancy');
            $table->date('admission');
            $table->date('contract1');
            $table->date('contract2');
            $table->float('salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clock');
    }
};
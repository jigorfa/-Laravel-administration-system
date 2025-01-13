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
        Schema::create('occurrence', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('employee_code');
            $table->foreign('employee_code')->references('code')->on('employee')->onDelete('cascade'); 
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations d.
     */
    public function down(): void
    {
        Schema::dropIfExists('occurrence');
    }
    
};
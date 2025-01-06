<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id('code');
            $table->string('ctps_code');
            $table->string('pis_code');
            $table->string('personal_code');
            $table->string('vote_code');
            $table->date('birth_date');
            $table->string('telephone');
            $table->string('name');
            $table->string('adjuntancy');
            $table->string('state');
            $table->string('city');
            $table->string('neighborhood');
            $table->integer('number');
            $table->string('postal_code');
            $table->string('street');
            $table->date('admission');
            $table->date('contract1');
            $table->date('contract2');
            $table->float('salary');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};

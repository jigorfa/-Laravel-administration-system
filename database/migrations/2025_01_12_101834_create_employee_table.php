<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->string('name');
            $table->date('birth_date');
            $table->string('nationality');
            $table->string('naturalness');
            $table->string('cpf_code');
            $table->string('ctps_code');
            $table->string('pis_code');
            $table->string('vote_code');
            $table->string('cnh_code')->nullable();
            $table->string('telephone');
            $table->string('postal_code');
            $table->string('address');
            $table->date('admission');
            $table->date('contract1');
            $table->date('contract2');
            $table->float('salary');
            $table->id('code');
            $table->string('adjuntancy');
            $table->date('demission')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};

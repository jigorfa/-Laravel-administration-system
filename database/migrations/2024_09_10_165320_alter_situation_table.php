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
        Schema::table('experience', function (Blueprint $table) {
            $table->foreignId('situation_id') // Nome da coluna local (chave estrangeira)
                ->default(3)
                ->after('name')
                ->constrained('situation'); // Nome da tabela referenciada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experience', function (Blueprint $table) {
            $table->dropForeign(['situation_id']);
            $table->dropColumn('situation_id');
        });
    }
};

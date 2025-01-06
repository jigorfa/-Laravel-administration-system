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
        Schema::table('occurrence_detail', function (Blueprint $table) {
            $table->foreignId('occasion_id') // Nome da coluna local (chave estrangeira)
                ->default(1)
                ->after('occurrence_id')
                ->constrained('occasion'); // Nome da tabela referenciada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('occurrence_detail', function (Blueprint $table) {
            $table->dropForeign(['occasion_id']);
            $table->dropColumn('occasion_id');
        });
    }
};

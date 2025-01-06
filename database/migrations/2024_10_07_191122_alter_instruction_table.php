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
        Schema::table('employee', function (Blueprint $table) {
            $table->foreignId('instruction_id') // Nome da coluna local (chave estrangeira)
                ->default(4)
                ->after('situation_id')
                ->constrained('instruction'); // Nome da tabela referenciada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign(['instruction_id']);
            $table->dropColumn('instruction_id');
        });
    }
};

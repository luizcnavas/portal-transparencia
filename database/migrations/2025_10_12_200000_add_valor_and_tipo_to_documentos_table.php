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
        Schema::table('documentos', function (Blueprint $table) {
            $table->decimal('valor', 15, 2)->default(0.00)->after('categoria');
            // 'tipo' categoriza o documento como 'receita' ou 'despesa' quando aplicável
            $table->string('tipo')->nullable()->after('valor'); // 'receita' or 'despesa'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn(['valor', 'tipo']);
        });
    }
};

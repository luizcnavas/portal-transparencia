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
        // Remove coluna categoria da tabela documentos
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
        
        // Remove coluna categoria da tabela financeiros
        Schema::table('financeiros', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
        
        // Remove coluna categoria da tabela legislacaos
        Schema::table('legislacaos', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recriar coluna categoria na tabela documentos
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('descricao');
        });
        
        // Recriar coluna categoria na tabela financeiros
        Schema::table('financeiros', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('descricao');
        });
        
        // Recriar coluna categoria na tabela legislacaos
        Schema::table('legislacaos', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('descricao');
        });
    }
};

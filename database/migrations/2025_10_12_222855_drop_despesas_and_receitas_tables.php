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
        // Anotação: migração que remove tabelas legadas `despesas` e `receitas`.
        // Executar apenas quando tiver certeza de que a migração é necessária.
        Schema::dropIfExists('despesas');
        Schema::dropIfExists('receitas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->decimal('valor', 8, 2);
            $table->date('data');
            $table->string('categoria');
            $table->timestamps();
        });

        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->decimal('valor', 8, 2);
            $table->date('data');
            $table->string('categoria');
            $table->timestamps();
        });
    }
};
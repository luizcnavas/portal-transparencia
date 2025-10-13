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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            // Usar precisão maior para manter compatibilidade com documentos
            // (15,2) permite valores grandes com duas casas decimais.
            $table->decimal('valor', 15, 2);
            $table->date('data');
            $table->string('categoria');
            // Ideal seria usar Enum: $table->enum('tipo', ['receita', 'despesa'])
            // porém optou-se por string para facilidade de migração/compatibilidade.
            $table->string('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};
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
        // Anotação: tabela legada para receitas. Usada em migrações históricas;
        // remova apenas se tiver certeza que nenhum seeder/legacy depende dela.
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->decimal('valor', 8, 2);
            $table->date('data');
            $table->string('categoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receitas');
    }
};

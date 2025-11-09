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
            $table->string('ata_diretoria')->nullable()->after('descricao');
            $table->string('cnpj')->nullable()->after('ata_diretoria');
            $table->string('icone')->nullable()->after('cnpj');
            $table->dropColumn(['valor', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn(['ata_diretoria', 'cnpj', 'icone']);
            $table->decimal('valor', 10, 2)->nullable();
            $table->enum('tipo', ['receita', 'despesa'])->nullable();
        });
    }
};

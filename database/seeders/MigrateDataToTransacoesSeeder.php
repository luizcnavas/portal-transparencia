<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Despesa;
use App\Models\Receita;
use App\Models\Transacao;

class MigrateDataToTransacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Limpa a tabela transacoes
            // Depende das tabelas legadas 'despesas' e 'receitas'
            Transacao::truncate();

            // 2. Migrar despesas
            Despesa::all()->each(function ($despesa) {
                Transacao::create([
                    'descricao' => $despesa->descricao,
                    'valor' => $despesa->valor,
                    'data' => $despesa->data,
                    'categoria' => $despesa->categoria,
                    'tipo' => 'despesa',
                    'created_at' => $despesa->created_at,
                    'updated_at' => $despesa->updated_at,
                ]);
            });

            // 3. Migrar receitas
            Receita::all()->each(function ($receita) {
                Transacao::create([
                    'descricao' => $receita->descricao,
                    'valor' => $receita->valor,
                    'data' => $receita->data,
                    'categoria' => $receita->categoria,
                    'tipo' => 'receita',
                    'created_at' => $receita->created_at,
                    'updated_at' => $receita->updated_at,
                ]);
            });
        });
    }
}

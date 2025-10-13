<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
         public function run(): void
        {
                // Cria um usuário único para login do admin
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]);
    
            // Passo 1: migra dados das tabelas antigas para a nova
            // ATENÇÃO: execute `php artisan db:seed` com cuidado — este seeder
            // migra dados das tabelas legadas (despesas/receitas). Rode apenas
            // UMA VEZ depois das migrations e com backup do banco.
            $this->call(MigrateDataToTransacoesSeeder::class);

            // Passo 2: depois da migração, comente/remova a chamada acima e
            // crie seeders de teste, por exemplo: $this->call(TransacaoSeeder::class);
        }}
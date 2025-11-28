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
                'email' => env('ADMIN_EMAIL', 'admin@example.com'),
                'password' => \Illuminate\Support\Facades\Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]);
    
            // Migra dados das tabelas antigas
            // ATENÇÃO: execute `php artisan db:seed` com cuidado
            // Rode apenas UMA VEZ depois das migrations e com backup do banco
            $this->call(MigrateDataToTransacoesSeeder::class);

            // Depois da migração, comente a linha acima
        }}
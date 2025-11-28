<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transacao;
use App\Models\Documento;

class DashboardTotalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_combined_totals_from_transacoes_and_documentos()
    {
        // Cria um usuário e autentica
        $user = User::factory()->create();

        // Cria transacoes
        Transacao::create(['descricao' => 'T1', 'valor' => 100.00, 'data' => now(), 'categoria' => 'A', 'tipo' => 'receita']);
        Transacao::create(['descricao' => 'T2', 'valor' => 40.00, 'data' => now(), 'categoria' => 'B', 'tipo' => 'despesa']);

        // Cria documentos com valor/tipo
        Documento::create(['titulo' => 'D1', 'descricao' => 'Doc 1', 'categoria' => 'C', 'caminho_arquivo' => 'doc.pdf', 'valor' => 50.00, 'tipo' => 'receita']);
        Documento::create(['titulo' => 'D2', 'descricao' => 'Doc 2', 'categoria' => 'D', 'caminho_arquivo' => 'doc2.pdf', 'valor' => 20.00, 'tipo' => 'despesa']);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSeeText('R$ 150,00')
            ->assertSeeText('R$ 60,00')
            ->assertSeeText('R$ 90,00');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transacao; // Changed from Documento
use App\Models\Documento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    // Anotação: agregamos valores de `Transacao` e `Documento` para os totais
    // exibidos no painel administrativo (receitas, despesas e saldo).
    $transacoesReceitas = Transacao::where('tipo', 'receita')->sum('valor');
    $transacoesDespesas = Transacao::where('tipo', 'despesa')->sum('valor');

    $documentosReceitas = Documento::where('tipo', 'receita')->sum('valor');
    $documentosDespesas = Documento::where('tipo', 'despesa')->sum('valor');

    $totalReceitas = $transacoesReceitas + $documentosReceitas;
    $totalDespesas = $transacoesDespesas + $documentosDespesas;
    $saldo = $totalReceitas - $totalDespesas;

        return view('admin.dashboard', compact('totalReceitas', 'totalDespesas', 'saldo'));
    }
}
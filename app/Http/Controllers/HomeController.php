<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacao; // Changed from Documento;
use App\Models\Documento;

class HomeController extends Controller
{
    /**
    * Exibe a página inicial com os totais financeiros.
    *
    * Anotação: aqui somamos valores de `Transacao` e `Documento` para
    * compor os números mostrados ao usuário (receitas, despesas e saldo).
    * Mantive a lógica de agregação; alteração é apenas de comentário.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
    // Soma valores de transacoes e documentos para os totais da home
    $transacoesReceitas = Transacao::where('tipo', 'receita')->sum('valor');
    $transacoesDespesas = Transacao::where('tipo', 'despesa')->sum('valor');

    $documentosReceitas = Documento::where('tipo', 'receita')->sum('valor');
    $documentosDespesas = Documento::where('tipo', 'despesa')->sum('valor');

    $totalReceitas = $transacoesReceitas + $documentosReceitas;
    $totalDespesas = $transacoesDespesas + $documentosDespesas;
    $saldo = $totalReceitas - $totalDespesas;

        return view('home', compact('totalReceitas', 'totalDespesas', 'saldo'));
    }
}

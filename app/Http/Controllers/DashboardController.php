<?php

namespace App\Http\Controllers;

use App\Models\Financeiro;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Busca os dados financeiros da tabela Financeiro
        $totalReceitas = Financeiro::where('tipo', 'receita')->sum('valor');
        $totalDespesas = Financeiro::where('tipo', 'despesa')->sum('valor');
        $saldo = $totalReceitas - $totalDespesas;

        return view('dashboard', compact('totalReceitas', 'totalDespesas', 'saldo'));
    }
}
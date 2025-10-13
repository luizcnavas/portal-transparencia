<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransacaoController extends Controller
{
    /**
     * Lista de transações (inclui documentos com valor quando aplicável).
     * Retorna uma paginação após mesclar transações e documentos.
     */
    public function index(Request $request)
    {
        $request->validate([
            'tipo' => 'nullable|in:receita,despesa',
        ]);

        $tipo = $request->query('tipo');

    // Buscar transações
        $transQuery = Transacao::query();
        if ($tipo) {
            $transQuery->where('tipo', $tipo);
        }
        $transItems = $transQuery->get()->map(function ($t) {
            return (object) [
                'id' => $t->id,
                'descricao' => $t->descricao,
                'tipo' => $t->tipo,
                'valor' => $t->valor,
                'data' => $t->data instanceof \Carbon\Carbon ? $t->data : \Carbon\Carbon::parse($t->data),
                'source' => 'transacao',
            ];
        });

    // Buscar documentos que tenham valor/tipo e incluí-los na listagem
        $docQuery = Documento::query();
        if ($tipo) {
            $docQuery->where('tipo', $tipo);
        }
    // Incluir somente documentos com campo 'valor' preenchido
        $docQuery->whereNotNull('valor');
        $docItems = $docQuery->get()->map(function ($d) {
            return (object) [
                'id' => 'doc-' . $d->id,
                'descricao' => $d->titulo ?? $d->descricao,
                'tipo' => $d->tipo,
                'valor' => $d->valor,
                'data' => $d->created_at instanceof \Carbon\Carbon ? $d->created_at : \Carbon\Carbon::parse($d->created_at),
                'source' => 'documento',
            ];
        });

    // Mesclar, ordenar por data (desc) e paginar
    // Garantir merge entre Support collections (stdClass), não Eloquent collections
    $merged = collect($transItems)->merge(collect($docItems))->sortByDesc('data')->values();

    // Paginação manual
        $perPage = 20;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = $merged->slice(($page - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator($results, $merged->count(), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        $transacoes = $paginator;

    // Define título dinâmico para a página
        $titulo = 'Transações';
        if ($tipo === 'receita') {
            $titulo = 'Receitas';
        } elseif ($tipo === 'despesa') {
            $titulo = 'Despesas';
        }

        return view('transacoes.index', compact('transacoes', 'titulo', 'tipo'));
    }

    /**
     * Mostra o detalhe de uma transação ou documento.
     * Aceita IDs no formato 'doc-<id>' para documentos.
     */
    public function show(string $transacao)
    {
    // Se o id começa com 'doc-' vem de um Documento
        if (is_string($transacao) && str_starts_with($transacao, 'doc-')) {
            $docId = substr($transacao, 4);
            $documento = Documento::findOrFail($docId);

            // Monta um objeto simples para reutilizar a view
            $item = (object) [
                'id' => 'doc-' . $documento->id,
                'descricao' => $documento->titulo ?? $documento->descricao,
                'tipo' => $documento->tipo,
                'valor' => $documento->valor,
                'data' => $documento->created_at,
                'source' => 'documento',
                'documento' => $documento,
            ];

            // Se for requisição AJAX, retorna só o partial (para modal)
            if (request()->ajax()) {
                return view('transacoes._detail', compact('item'));
            }

            return view('transacoes.show', compact('item'));
        }

    // Caso contrário, é um id de Transacao
        $trans = Transacao::findOrFail($transacao);
        $item = (object) [
            'id' => $trans->id,
            'descricao' => $trans->descricao,
            'tipo' => $trans->tipo,
            'valor' => $trans->valor,
            'data' => $trans->data,
            'source' => 'transacao',
            'transacao' => $trans,
        ];

        if (request()->ajax()) {
            return view('transacoes._detail', compact('item'));
        }

        return view('transacoes.show', compact('item'));
    }
}
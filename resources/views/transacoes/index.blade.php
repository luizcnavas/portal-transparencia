@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Título definido no controller: 'Receitas' | 'Despesas' | 'Transações' --}}
    <h1 class="mb-4">{{ $titulo }}</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Descrição</th>
                {{-- Só mostra a coluna 'Tipo' se não estivermos filtrando por um tipo específico --}}
                @if(!$tipo)
                    <th scope="col">Tipo</th>
                @endif
                <th scope="col">Valor</th>
                <th scope="col">Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transacoes as $transacao)
                <tr>
                    <th scope="row">{{ $transacao->id }}</th>
                    <td>{{ $transacao->descricao }}</td>
                        {{-- Mostrar o tipo quando não estiver filtrado --}}
                    @if(!$tipo)
                        <td>
                            @if($transacao->tipo === 'receita')
                                <span class="badge bg-success">Receita</span>
                            @else
                                <span class="badge bg-danger">Despesa</span>
                            @endif
                        </td>
                    @endif
                    {{-- Cor do valor aplicada conforme o tipo --}}
                    <td class="{{ $transacao->tipo === 'receita' ? 'text-success' : 'text-danger' }}">
                        R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                    </td>
                    <td>{{ $transacao->data->format('d/m/Y') }}</td>
                    <td>
                        @if(isset($transacao->source) && $transacao->source === 'documento')
                            {{-- documentos têm id no formato 'doc-<id>' no paginator --}}
                            @php
                                $docId = (string) $transacao->id;
                                if (str_starts_with($docId, 'doc-')) {
                                    $docId = substr($docId, 4);
                                }
                            @endphp
                            {{-- Aponta para transacoes.show com prefixo 'doc-' para permitir modal AJAX --}}
                            <a href="{{ route('transacoes.show', ['transacao' => 'doc-' . $docId]) }}" class="btn btn-sm btn-primary btn-detail" data-href="{{ route('transacoes.show', ['transacao' => 'doc-' . $docId]) }}">Ver detalhes</a>
                        @else
                            <a href="{{ route('transacoes.show', ['transacao' => $transacao->id]) }}" class="btn btn-sm btn-primary btn-detail" data-href="{{ route('transacoes.show', ['transacao' => $transacao->id]) }}">Ver detalhes</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ !$tipo ? '5' : '4' }}" class="text-center">Nenhuma {{ $tipo ?? 'transação' }} encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Mantém o filtro 'tipo' nos links de paginação --}}
        {{ $transacoes->withQueryString()->links() }}

        <!-- Modal de detalhes -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalhes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detailContent">Carregando...</div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function () {
                const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

                document.querySelectorAll('.btn-detail').forEach(function (el) {
                        el.addEventListener('click', function (e) {
                                e.preventDefault();
                                const href = el.getAttribute('data-href');
                                const content = document.getElementById('detailContent');
                                content.innerHTML = 'Carregando...';

                                fetch(href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                                        .then(function (res) { return res.text(); })
                                        .then(function (html) {
                                                content.innerHTML = html;
                                                detailModal.show();
                                        }).catch(function (err) {
                                                content.innerHTML = '<div class="text-danger">Erro ao carregar detalhes.</div>';
                                                detailModal.show();
                                        });
                        });
                });
        });
        </script>
        @endpush
</div>
@endsection

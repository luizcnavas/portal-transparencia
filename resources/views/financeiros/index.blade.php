@extends('layouts.app')
@push('styles')
<style>
    table.table thead.cabecalho th {
        background-color: #20752b !important;
        color: #fff !important;
    }
    table.table thead.cabecalho th:first-child {
        border-top-left-radius: 8px;
    }

    table.table thead.cabecalho th:last-child {
        border-top-right-radius: 8px;
    }

</style>
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="titulo">Financeiro</h1>
        @auth
            <a href="{{ route('admin.financeiros.create') }}" class="btn btn-primary add">Adicionar Registro</a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4 fundoCard">
        <div class="filtro">
            <form method="GET" action="{{ route('financeiros.index') }}">
                <div class="row">
                    <div class="col-md-4 respEspaco">
                        <select name="tipo" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="receita" {{ request('tipo') == 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-6 respEspaco">
                        <input type="text" name="search" class="form-control" placeholder="Pesquisar..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 respEspaco">
                        <button type="submit" class="btn btn-secondary w-100 btnFiltro">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive voltaTab">
            <table class="table table-hover tabela">
                <thead class="cabecalho">
                    <tr>
                        <th class="TituloTabela">Título</th>
                        <th class="TituloTabela">Tipo</th>
                        <th class="TituloTabela">Valor</th>
                        <th class="TituloTabela">Planejamento Estratégico</th>
                        <th class="TituloTabela">Data de Publicação</th>
                        <th class="TituloTabelaAcao acaoFinanceiro">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($financeiros as $financeiro)
                        <tr>
                            <td>{{ $financeiro->titulo }}</td>
                            <td>
                                @if($financeiro->tipo === 'receita')
                                    <span class="badge bg-success">Receita</span>
                                @else
                                    <span class="badge bg-danger">Despesa</span>
                                @endif
                            </td>
                            <td>R$ {{ number_format($financeiro->valor, 2, ',', '.') }}</td>
                            <td>{{ Str::limit($financeiro->planejamento_estrategico ?? '—', 50) }}</td>
                            <td>{{ $financeiro->created_at->format('d/m/Y') }}</td>
                            <td class="text-end btnsTab">
                                <a href="{{ route('financeiros.show', $financeiro) }}" class="btn btn-sm botaoTab me-1"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/olho.png') }}" alt="Detalhes"/></a>
                                <a href="{{ route('financeiros.download', $financeiro) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/download.png') }}" alt="Baixar"/></a>
                                @auth
                                    <a href="{{ route('admin.financeiros.edit', $financeiro) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                    <form action="{{ route('admin.financeiros.destroy', $financeiro) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                    </form>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($financeiros->hasPages())
            <div class="card-footer">
                {{ $financeiros->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection

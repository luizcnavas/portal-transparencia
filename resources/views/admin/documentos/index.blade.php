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
        <h1 class="titulo">Gerenciar Documentos</h1>
        <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary add">Adicionar Novo</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.documentos.index') }}">
                <div class="row g-2">
                    <div class="col-md-3">
                        <select name="tipo" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="receita" {{ request('tipo') == 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="table-responsive voltaTab">
            <table class="table table-hover tabela">
                <thead class="cabecalho">
                    <tr>
                        <th class="TituloTabela">Título</th>
                        <th class="TituloTabela">Ata de Diretoria</th>
                        <th class="TituloTabela">CNPJ</th>
                        <th class="TituloTabela">Data de Upload</th>
                        <th class="TituloTabelaAcao">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $documento)
                        <tr>
                            <td>{{ $documento->titulo }}</td>
                            <td>{{ $documento->ata_diretoria ?? '—' }}</td>
                            <td>{{ $documento->cnpj ?? '—' }}</td>
                            <td>{{ $documento->created_at->format('d/m/Y') }}</td>
                            <td class="text-end btnsTab">
                                <a href="{{ route('documentos.show', $documento) }}" class="btn btn-sm me-1 botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/olho.png') }}" alt="Detalhes"/></a>
                                <a href="{{ route('documentos.download', $documento) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/download.png') }}" alt="Baixar"/></a>
                                <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum documento encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($documentos->hasPages())
            <div class="card-footer">
                {{ $documentos->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
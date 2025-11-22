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
        <h1>Documentos</h1>
        @auth
            <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">Adicionar Documento</a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="voltaTab">
            <table class="table table-hover tabela">
                <thead class="cabecalho">
                    <tr>
                        <th class="TituloTabela">Título</th>
                        <th class="TituloTabela">Ata de Diretoria</th>
                        <th class="TituloTabela">CNPJ</th>
                        <th class="TituloTabela">Data de Publicação</th>
                        <th class="text-end TituloTabela">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $documento)
                        <tr>
                            <td>{{ $documento->titulo }}</td>
                            <td>{{ $documento->ata_diretoria ?? '—' }}</td>
                            <td>{{ $documento->cnpj ?? '—' }}</td>
                            <td>{{ $documento->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('documentos.show', $documento) }}" class="btn btn-sm btn-info me-1">Detalhes</a>
                                <a href="{{ route('documentos.download', $documento) }}" class="btn btn-sm btn-success">Baixar</a>
                                @auth
                                    <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                @endauth
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
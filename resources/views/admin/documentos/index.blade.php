@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Documentos</h1>
        <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">Adicionar Novo</a>
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
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Ata de Diretoria</th>
                        <th>CNPJ</th>
                        <th>Data de Upload</th>
                        <th class="text-end">Ações</th>
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
                                <a href="{{ route('documentos.download', $documento) }}" class="btn btn-sm btn-success me-1">Baixar</a>
                                <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
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
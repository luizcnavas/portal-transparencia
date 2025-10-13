@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Documentos</h1>
        @auth
            <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">Adicionar Documento</a>
        @endauth
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('documentos.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <select name="categoria" class="form-select">
                            <option value="">Todas as categorias</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                    {{ $categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                        <div class="col-md-3">
                            <select name="tipo" class="form-select">
                                <option value="">Todos os tipos</option>
                                <option value="receita" {{ request('tipo') == 'receita' ? 'selected' : '' }}>Receita</option>
                                <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                            </select>
                        </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Data de Publicação</th>
                        <th class="text-end">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $documento)
                        <tr>
                            <td>{{ $documento->titulo }}</td>
                            
                            <td>{{ $documento->categoria }}</td>
                            
                            <td>
                                @if($documento->tipo === 'receita')
                                    <span class="badge bg-success">Receita</span>
                                @elseif($documento->tipo === 'despesa')
                                    <span class="badge bg-danger">Despesa</span>
                                @else
                                    <span class="badge bg-secondary">—</span>
                                @endif
                            </td>
                            <td>R$ {{ number_format($documento->valor ?? 0, 2, ',', '.') }}</td>
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
                            <td colspan="6" class="text-center">Nenhum documento encontrado.</td>
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
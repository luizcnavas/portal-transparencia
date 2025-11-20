@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Financeiro</h1>
        @auth
            <a href="{{ route('admin.financeiros.create') }}" class="btn btn-primary">Adicionar Registro</a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('financeiros.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <select name="tipo" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="receita" {{ request('tipo') == 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Pesquisar..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
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
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Planejamento Estratégico</th>
                        <th>Data de Publicação</th>
                        <th class="text-end">Ação</th>
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
                            <td class="text-end">
                                <a href="{{ route('financeiros.show', $financeiro) }}" class="btn btn-sm btn-info me-1">Detalhes</a>
                                <a href="{{ route('financeiros.download', $financeiro) }}" class="btn btn-sm btn-success">Baixar</a>
                                @auth
                                    <a href="{{ route('admin.financeiros.edit', $financeiro) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('admin.financeiros.destroy', $financeiro) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
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

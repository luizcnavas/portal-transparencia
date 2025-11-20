@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Legislação</h1>
        @auth
            <a href="{{ route('admin.legislacoes.create') }}" class="btn btn-primary">Adicionar Legislação</a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estatuto Social</th>
                        <th>Certificado Nacional</th>
                        <th>Data de Publicação</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($legislacoes as $legislacao)
                        <tr>
                            <td>{{ $legislacao->titulo }}</td>
                            <td>{{ $legislacao->estatuto_social ?? '—' }}</td>
                            <td>{{ $legislacao->certificado_nacional ?? '—' }}</td>
                            <td>{{ $legislacao->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('legislacoes.show', $legislacao) }}" class="btn btn-sm btn-info me-1">Detalhes</a>
                                <a href="{{ route('legislacoes.download', $legislacao) }}" class="btn btn-sm btn-success">Baixar</a>
                                @auth
                                    <a href="{{ route('admin.legislacoes.edit', $legislacao) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('admin.legislacoes.destroy', $legislacao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma legislação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($legislacoes->hasPages())
            <div class="card-footer">
                {{ $legislacoes->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection

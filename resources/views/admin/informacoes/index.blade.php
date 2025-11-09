@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Informações</h1>
        <a href="{{ route('admin.informacoes.create') }}" class="btn btn-primary">Adicionar Informação</a>
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
                        <th>Conteúdo</th>
                        <th>Documento</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informacoes as $informacao)
                        <tr>
                            <td>{{ $informacao->titulo }}</td>
                            <td>{{ Str::limit($informacao->conteudo, 50) }}</td>
                            <td>
                                @if($informacao->caminho_documento)
                                    <span class="badge bg-success">Sim</span>
                                @else
                                    <span class="badge bg-secondary">Não</span>
                                @endif
                            </td>
                            <td>{{ $informacao->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.informacoes.edit', $informacao) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.informacoes.destroy', $informacao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma informação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($informacoes->hasPages())
            <div class="card-footer">
                {{ $informacoes->links() }}
            </div>
        @endif
    </div>
@endsection

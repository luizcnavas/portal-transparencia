@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Notícias</h1>
        <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">Adicionar Nova</a>
    </div>
    {{-- Anotação: lista de notícias para administração; ações de CRUD disponíveis. --}}

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
                        <th>Data de Criação</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($noticias as $noticia)
                        <tr>
                            <td>{{ $noticia->titulo }}</td>
                            <td>{{ $noticia->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma notícia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($noticias->hasPages())
            <div class="card-footer">
                {{ $noticias->links() }}
            </div>
        @endif
    </div>
@endsection
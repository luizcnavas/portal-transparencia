@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Notícias</h1>
        @auth
            <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">Adicionar Notícia</a>
        @endauth
    </div>

    <div class="row">
        @forelse($noticias as $noticia)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $noticia->titulo }}</h2>
                        <p class="card-text"><small class="text-muted">Publicado em {{ $noticia->created_at->format('d/m/Y') }}</small></p>
                        <p class="card-text">{{ Str::limit($noticia->conteudo, 200) }}</p>
                        <a href="{{ route('noticias.show', $noticia) }}" class="btn btn-secondary">Leia mais</a>
                         @auth
                            <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p>Nenhuma notícia encontrada.</p>
            </div>
        @endforelse
    </div>
    @if($noticias->hasPages())
        <div class="d-flex justify-content-center">
            {{ $noticias->links() }}
        </div>
    @endif
@endsection
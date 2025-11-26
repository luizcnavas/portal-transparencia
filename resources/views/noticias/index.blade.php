@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="titulo">Notícias</h1>
        @auth
            <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary add">Adicionar Notícia</a>
        @endauth
    </div>

    <div class="row">
        @forelse($noticias as $noticia)
            <div class="@if($loop->first) col-md-8 destaque @else col-md-4 @endif mb-4">
                <div class="card cardNoticia">
                    <div class="card-body">
                        <h2 class="card-title tituloNoticia">{{ $noticia->titulo }}</h2>
                        <p class="card-text"><small class="text-muted dataNoticia">Publicado em {{ $noticia->created_at->format('d/m/Y') }}</small></p>
                        <p class="card-text txtNoticia {{ $loop->first ? 'txtDestaque' : '' }}">
                            {{ Str::limit($noticia->conteudo, $loop->first ? 700 : 200) }}
                        </p>
                        <div class="btnNoticia">
                            <a href="{{ route('noticias.show', $noticia) }}" class="btn lerMais">Leia mais</a>
                            @auth
                                <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                </form>
                            @endauth
                        </div>
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
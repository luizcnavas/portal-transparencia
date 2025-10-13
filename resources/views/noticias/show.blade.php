@extends('layouts.app')

@section('content')
    <article>
        <h1>{{ $noticia->titulo }}</h1>
        <p class="text-muted">Publicado em {{ $noticia->created_at->format('d/m/Y') }}</p>
        <div class="fs-5">
            {!! nl2br(e($noticia->conteudo)) !!}
        </div>
    </article>
    <hr class="my-4">
    <a href="{{ route('noticias.index') }}" class="btn btn-light">Voltar para Notícias</a>
@endsection
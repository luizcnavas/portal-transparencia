@extends('layouts.app')

@section('content')
    <h1>Editar Notícia</h1>
    {{-- Anotação: editar conteúdo da notícia; preserva histórico em banco (se necessário). --}}

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.noticias.update', $noticia) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $noticia->titulo }}" required>
                </div>
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="10" required>{{ $noticia->conteudo }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('admin.noticias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
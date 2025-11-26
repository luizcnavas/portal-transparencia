@extends('layouts.app')

@section('content')
    <h1>Adicionar Nova Notícia</h1>
    {{-- Anotação: formulário para criar uma notícia pública; conteúdo livre (HTML não permitido). --}}

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.noticias.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="10" required></textarea>
                </div>
                <button type="submit" class="btn add">Salvar</button>
                <a href="{{ route('admin.noticias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
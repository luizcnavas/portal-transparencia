@extends('layouts.app')

@section('content')
    <h1>Editar Informação</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.informacoes.update', $informacao) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $informacao->titulo }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="5" required>{{ $informacao->conteudo }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="informacoes_institucionais" class="form-label">Informações Institucionais</label>
                    <textarea class="form-control" id="informacoes_institucionais" name="informacoes_institucionais" rows="4">{{ $informacao->informacoes_institucionais }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="impacto_social" class="form-label">Impacto Social</label>
                    <textarea class="form-control" id="impacto_social" name="impacto_social" rows="4">{{ $informacao->impacto_social }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="estrutura_administrativa" class="form-label">Estrutura Administrativa</label>
                    <textarea class="form-control" id="estrutura_administrativa" name="estrutura_administrativa" rows="4">{{ $informacao->estrutura_administrativa }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="contatos" class="form-label">Contatos</label>
                    <textarea class="form-control" id="contatos" name="contatos" rows="3">{{ $informacao->contatos }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="{{ route('admin.informacoes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

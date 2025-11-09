@extends('layouts.app')

@section('content')
    <h1>Adicionar Nova Informação</h1>

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
            <form action="{{ route('admin.informacoes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="informacoes_institucionais" class="form-label">Informações Institucionais</label>
                    <textarea class="form-control" id="informacoes_institucionais" name="informacoes_institucionais" rows="4"></textarea>
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="impacto_social" class="form-label">Impacto Social</label>
                    <textarea class="form-control" id="impacto_social" name="impacto_social" rows="4"></textarea>
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="estrutura_administrativa" class="form-label">Estrutura Administrativa</label>
                    <textarea class="form-control" id="estrutura_administrativa" name="estrutura_administrativa" rows="4"></textarea>
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="contatos" class="form-label">Contatos</label>
                    <textarea class="form-control" id="contatos" name="contatos" rows="3"></textarea>
                    <small class="text-muted">Campo opcional - Adicione telefones, emails, endereços, etc.</small>
                </div>

                <div class="mb-3">
                    <label for="documento" class="form-label">Documento Anexo</label>
                    <input class="form-control" type="file" id="documento" name="documento">
                    <small class="text-muted">Campo opcional - Anexe um documento relacionado se necessário</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('admin.informacoes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <h1>Editar Documento</h1>
    {{-- Anotação: edição apenas de metadados; o arquivo em si não é substituído aqui. --}}

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.documentos.update', $documento) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $documento->titulo }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $documento->descricao }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" value="{{ $documento->categoria }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="receita" {{ $documento->tipo == 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="despesa" {{ $documento->tipo == 'despesa' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="valor" class="form-label">Valor (R$)</label>
                        <input type="number" class="form-control" id="valor" name="valor" value="{{ $documento->valor }}" step="0.01" min="0" required>
                    </div>
                </div>

                <p class="text-muted">A troca de arquivo não é permitida. Para alterar o arquivo, exclua este documento e crie um novo.</p>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
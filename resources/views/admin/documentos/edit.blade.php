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
                    <label for="ata_diretoria" class="form-label">Ata de Diretoria</label>
                    <input type="text" class="form-control" id="ata_diretoria" name="ata_diretoria" value="{{ $documento->ata_diretoria }}">
                </div>

                <div class="mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $documento->cnpj }}" placeholder="00.000.000/0000-00">
                </div>

                <p class="text-muted">A troca de arquivo não é permitida. Para alterar o arquivo, exclua este documento e crie um novo.</p>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
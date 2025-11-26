@extends('layouts.app')

@section('content')
    <h1 class="titulo">Adicionar Novo Documento</h1>
    {{-- Anotação: formulário simples para criar documento com metadados e upload de arquivo. --}}

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
            <form action="{{ route('admin.documentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="ata_diretoria" class="form-label">Ata de Diretoria</label>
                    <input type="text" class="form-control" id="ata_diretoria" name="ata_diretoria">
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00">
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="arquivo" class="form-label">Arquivo</label>
                    <input class="form-control" type="file" id="arquivo" name="arquivo" required>
                </div>
                <button type="submit" class="btn add">Salvar</button>
                <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
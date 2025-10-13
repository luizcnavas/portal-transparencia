@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Documento</h1>
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
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="" disabled selected>Selecione o tipo</option>
                            <option value="receita">Receita</option>
                            <option value="despesa">Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="valor" class="form-label">Valor (R$)</label>
                        <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="arquivo" class="form-label">Arquivo</label>
                    <input class="form-control" type="file" id="arquivo" name="arquivo" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
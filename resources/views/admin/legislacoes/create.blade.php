@extends('layouts.app')

@section('content')
    <h1>Adicionar Nova Legislação</h1>

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
            <form action="{{ route('admin.legislacoes.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="estatuto_social" class="form-label">Estatuto Social</label>
                    <input type="text" class="form-control" id="estatuto_social" name="estatuto_social">
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="certificado_nacional" class="form-label">Certificado Nacional</label>
                    <input type="text" class="form-control" id="certificado_nacional" name="certificado_nacional">
                    <small class="text-muted">Campo opcional</small>
                </div>

                <div class="mb-3">
                    <label for="arquivo" class="form-label">Arquivo</label>
                    <input class="form-control" type="file" id="arquivo" name="arquivo" required>
                </div>
                <button type="submit" class="btn add">Salvar</button>
                <a href="{{ route('admin.legislacoes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

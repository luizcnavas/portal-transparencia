@extends('layouts.app')

@section('content')
    <h1>Editar Legislação</h1>

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
            <form action="{{ route('admin.legislacoes.update', $legislacao) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $legislacao->titulo }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $legislacao->descricao }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="estatuto_social" class="form-label">Estatuto Social</label>
                    <input type="text" class="form-control" id="estatuto_social" name="estatuto_social" value="{{ $legislacao->estatuto_social }}">
                </div>

                <div class="mb-3">
                    <label for="certificado_nacional" class="form-label">Certificado Nacional</label>
                    <input type="text" class="form-control" id="certificado_nacional" name="certificado_nacional" value="{{ $legislacao->certificado_nacional }}">
                </div>

                <button type="submit" class="btn add">Atualizar</button>
                <a href="{{ route('admin.legislacoes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

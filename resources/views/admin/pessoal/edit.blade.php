@extends('layouts.app')

@section('content')
    <h1>Editar Pessoa</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pessoal.update', $pessoal) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome"
                           value="{{ $pessoal->nome }}" required>
                </div>

                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input type="text" class="form-control" id="cargo" name="cargo"
                           value="{{ $pessoal->cargo }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto atual</label><br>

                    @if ($pessoal->foto)
                        <img src="{{ asset('storage/' . $pessoal->foto) }}" alt="Foto" width="150" class="mb-2 rounded">
                    @else
                        <p class="text-muted">Nenhuma foto cadastrada.</p>
                    @endif

                    <input type="file" class="form-control mt-2" id="foto" name="foto">
                </div>

                <button type="submit" class="btn add">Salvar Alterações</button>
                <a href="{{ route('admin.pessoal.index') }}" class="btn btn-secondary">Cancelar</a>

@endsection
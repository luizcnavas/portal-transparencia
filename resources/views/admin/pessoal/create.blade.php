@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Adicionar Pessoa</h1>

    <form action="{{ route('admin.pessoal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <input type="text" name="cargo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Campo opcional</small>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection

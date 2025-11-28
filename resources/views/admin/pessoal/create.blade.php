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

        @if($isMainAdmin)
            <div class="alert alert-info">
                <strong>ℹ️ Permissões de Admin Principal</strong><br>
                Apenas você, como administrador principal, pode criar credenciais de login para outros usuários.
            </div>
            <hr>
            <h4>Dados de Login (Opcional)</h4>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="min 6 caracteres">
            </div>
            <hr>
        @endif

        <button type="submit" class="btn add">Salvar</button>
        <a href="{{ route('admin.pessoal.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

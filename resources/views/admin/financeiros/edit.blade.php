@extends('layouts.app')

@section('content')
    <h1>Editar Registro Financeiro</h1>

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
            <form action="{{ route('admin.financeiros.update', $financeiro) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $financeiro->titulo }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $financeiro->descricao }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="receita" {{ $financeiro->tipo == 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="despesa" {{ $financeiro->tipo == 'despesa' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="valor" class="form-label">Valor (R$)</label>
                        <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" value="{{ $financeiro->valor }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="planejamento_estrategico" class="form-label">Planejamento Estratégico</label>
                    <textarea class="form-control" id="planejamento_estrategico" name="planejamento_estrategico" rows="4">{{ $financeiro->planejamento_estrategico }}</textarea>
                </div>

                <button type="submit" class="btn add">Atualizar</button>
                <a href="{{ route('admin.financeiros.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $financeiro->titulo }}</h1>
            <p class="text-muted">Publicado em {{ $financeiro->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>Tipo:</strong>
                    @if($financeiro->tipo === 'receita')
                        <span class="badge bg-success">Receita</span>
                    @else
                        <span class="badge bg-danger">Despesa</span>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>Valor:</strong> R$ {{ number_format($financeiro->valor, 2, ',', '.') }}
                </div>
            </div>

            <div class="mb-3">
                <strong>Descrição:</strong>
                <p>{{ $financeiro->descricao }}</p>
            </div>

            @if($financeiro->planejamento_estrategico)
                <div class="mb-3">
                    <strong>Planejamento Estratégico:</strong>
                    <p>{{ $financeiro->planejamento_estrategico }}</p>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('financeiros.download', $financeiro) }}" class="btn btn-success">Baixar Documento</a>
                @php
                    $extensao = strtolower(pathinfo($financeiro->caminho_arquivo, PATHINFO_EXTENSION));
                    $podeVisualizar = in_array($extensao, ['pdf', 'png', 'jpg', 'jpeg']);
                @endphp
                @if($podeVisualizar)
                    <a href="{{ route('financeiros.preview', $financeiro) }}" class="btn btn-info">Visualizar Arquivo</a>
                @endif
                <a href="{{ route('financeiros.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection

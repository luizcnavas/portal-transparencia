@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $legislacao->titulo }}</h1>
            <p class="text-muted">Publicado em {{ $legislacao->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Descrição:</strong>
                <p>{{ $legislacao->descricao }}</p>
            </div>

            @if($legislacao->estatuto_social)
                <div class="mb-3">
                    <strong>Estatuto Social:</strong>
                    <p>{{ $legislacao->estatuto_social }}</p>
                </div>
            @endif

            @if($legislacao->certificado_nacional)
                <div class="mb-3">
                    <strong>Certificado Nacional:</strong>
                    <p>{{ $legislacao->certificado_nacional }}</p>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('legislacoes.download', $legislacao) }}" class="btn btn-success">Baixar Documento</a>
                @php
                    $extensao = strtolower(pathinfo($legislacao->caminho_arquivo, PATHINFO_EXTENSION));
                    $podeVisualizar = in_array($extensao, ['pdf', 'png', 'jpg', 'jpeg']);
                @endphp
                @if($podeVisualizar)
                    <a href="{{ route('legislacoes.preview', $legislacao) }}" class="btn btn-info">Visualizar Arquivo</a>
                @endif
                <a href="{{ route('legislacoes.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $informacao->titulo }}</h1>
            <p class="text-muted">Publicado em {{ $informacao->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h4>Conteúdo</h4>
                <p style="white-space: pre-wrap;">{{ $informacao->conteudo }}</p>
            </div>

            @if($informacao->informacoes_institucionais)
                <div class="mb-4">
                    <h4 class="text-success">Informações Institucionais</h4>
                    <p style="white-space: pre-wrap;">{{ $informacao->informacoes_institucionais }}</p>
                </div>
            @endif

            @if($informacao->impacto_social)
                <div class="mb-4">
                    <h4 class="text-primary">Impacto Social</h4>
                    <p style="white-space: pre-wrap;">{{ $informacao->impacto_social }}</p>
                </div>
            @endif

            @if($informacao->estrutura_administrativa)
                <div class="mb-4">
                    <h4 class="text-info">Estrutura Administrativa</h4>
                    <p style="white-space: pre-wrap;">{{ $informacao->estrutura_administrativa }}</p>
                </div>
            @endif

            @if($informacao->contatos)
                <div class="mb-4">
                    <h4 class="text-warning">Contatos</h4>
                    <p style="white-space: pre-wrap;">{{ $informacao->contatos }}</p>
                </div>
            @endif

            <div class="mt-4">
                @if($informacao->caminho_documento)
                    <a href="{{ route('informacoes.download', $informacao) }}" class="btn btn-success">Baixar Documento Anexo</a>
                @endif
                <a href="{{ route('informacoes.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection

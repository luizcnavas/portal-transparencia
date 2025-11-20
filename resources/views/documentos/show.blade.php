@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">Detalhes do Documento</h1>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
        </div>
        <div class="card-body">
            <h2 class="h5">{{ $documento->titulo }}</h2>
            <hr>
            <dl class="row">
                <dt class="col-sm-3">Data de Publicação</dt>
                <dd class="col-sm-9">{{ $documento->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><p>{!! nl2br(e($documento->descricao)) !!}</p></dd>

                @if($documento->ata_diretoria)
                    <dt class="col-sm-3">Ata de Diretoria</dt>
                    <dd class="col-sm-9">{{ $documento->ata_diretoria }}</dd>
                @endif

                @if($documento->cnpj)
                    <dt class="col-sm-3">CNPJ</dt>
                    <dd class="col-sm-9">{{ $documento->cnpj }}</dd>
                @endif
            </dl>

            <hr>
            <h4>Arquivo</h4>
            @php
                $extensao = strtolower(pathinfo($documento->caminho_arquivo, PATHINFO_EXTENSION));
                $podeVisualizar = in_array($extensao, ['pdf', 'png', 'jpg', 'jpeg']);
            @endphp
            @if ($podeVisualizar)
                <a href="{{ route('documentos.preview', $documento) }}" class="btn btn-info me-1" target="_blank">Visualizar Arquivo</a>
            @endif
            <a href="{{ route('documentos.download', $documento) }}" class="btn btn-success">Baixar Arquivo</a>
        </div>
    </div>
@endsection
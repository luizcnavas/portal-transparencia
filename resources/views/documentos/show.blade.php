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
                <dt class="col-sm-3">Categoria</dt>
                <dd class="col-sm-9">{{ $documento->categoria }}</dd>

                <dt class="col-sm-3">Data de Publicação</dt>
                <dd class="col-sm-9">{{ $documento->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><p>{!! nl2br(e($documento->descricao)) !!}</p></dd>

                <dt class="col-sm-3">Lançamento Financeiro</dt>
                <dd class="col-sm-9">
                    @if($documento->tipo == 'receita')
                        <span class="badge bg-success fs-6">Receita: R$ {{ number_format($documento->valor, 2, ',', '.') }}</span>
                    @elseif($documento->tipo == 'despesa')
                        <span class="badge bg-danger fs-6">Despesa: R$ {{ number_format($documento->valor, 2, ',', '.') }}</span>
                    @else
                        <span class="text-muted">Não especificado</span>
                    @endif
                </dd>
            </dl>

            <hr>
            <h4>Arquivo</h4>
            @if (\Illuminate\Support\Str::endsWith($documento->caminho_arquivo, '.pdf'))
                <a href="{{ route('documentos.preview', $documento) }}" class="btn btn-info me-1" target="_blank">Visualizar Arquivo</a>
            @endif
            <a href="{{ route('documentos.download', $documento) }}" class="btn btn-success">Baixar Arquivo</a>
        </div>
    </div>
@endsection
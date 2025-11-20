@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Visualizando: {{ $legislacao->titulo }}</h1>
        <a href="{{ route('legislacoes.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    <div class="card">
        <div class="card-body p-0" style="height: 80vh;">
            @if(isset($ehImagem) && $ehImagem)
                <div class="d-flex justify-content-center align-items-center h-100 p-3">
                    <img src="{{ $url }}" class="img-fluid" alt="{{ $legislacao->titulo }}" style="max-height: 100%; object-fit: contain;">
                </div>
            @else
                <iframe src="{{ $url }}" width="100%" height="100%" frameborder="0"></iframe>
            @endif
        </div>
    </div>
@endsection

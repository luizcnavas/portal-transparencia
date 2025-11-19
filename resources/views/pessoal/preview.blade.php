@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Visualizando: {{ $pessoa->nome }}</h1>
        <a href="{{ route('pessoal.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>

    <div class="card">
        <div class="card-body p-0" style="height: 80vh;">
            <iframe src="{{ $url }}" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
@endsection
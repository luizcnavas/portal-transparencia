@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bem-vindo ao Portal da Transparência da AEAPS</h1>
        <p class="col-md-8 fs-4">
            Este espaço é dedicado a fornecer acesso claro e aberto às informações sobre as atividades, finanças e governança da nossa associação.
        </p>
        <a href="{{ route('documentos.index') }}" class="btn btn-primary btn-lg" type="button">Ver Documentos</a>
        <a href="{{ route('noticias.index') }}" class="btn btn-secondary btn-lg" type="button">Ler Notícias</a>
    </div>
</div>

{{-- Financial Summary --}}
<div class="container">
    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total de Receitas</h5>
                    <p class="card-text fs-4">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total de Despesas</h5>
                    <p class="card-text fs-4">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white {{ $saldo >= 0 ? 'bg-primary' : 'bg-warning' }}">
                <div class="card-body">
                    <h5 class="card-title">Saldo Final</h5>
                    <p class="card-text fs-4">R$ {{ number_format($saldo, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

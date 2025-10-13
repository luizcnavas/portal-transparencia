@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total de Despesas</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total de Receitas</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white {{ $balanco >= 0 ? 'bg-primary' : 'bg-warning' }} mb-3">
                <div class="card-header">Balanço Final</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ number_format($balanco, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Placeholder for charts --}}
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Gráficos</div>
                <div class="card-body" style="height: 300px;">
                    <p class="text-center">Gráficos serão implementados aqui.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
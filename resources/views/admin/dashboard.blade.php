@extends('layouts.app')

@section('content')
    <h1 class="titulo">Dashboard Financeiro</h1>
    <p>Aqui está um resumo financeiro baseado nos documentos cadastrados no portal.</p>
    <hr>

    {{-- Resumo financeiro: valores agregados para exibição rápida. --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title numero">Total de Receitas</h5>
                    <p class="card-text fs-4">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title numero">Total de Despesas</h5>
                    <p class="card-text fs-4">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white {{ $saldo >= 0 ? 'bg-primary' : 'bg-warning' }}">
                <div class="card-body">
                    <h5 class="card-title numero">Saldo Final</h5>
                    <p class="card-text fs-4">R$ {{ number_format($saldo, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico financeiro: representações visuais (Chart.js). --}}
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <canvas id="financeChartAdmin"></canvas>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxAdmin = document.getElementById('financeChartAdmin');

        new Chart(ctxAdmin, {
            type: 'pie',
            data: {
                labels: ['Receitas', 'Despesas'],
                datasets: [{
                    label: 'Valor em R$',
                    data: [{{ $totalReceitas }}, {{ $totalDespesas }}],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(25, 135, 84, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Receitas e Despesas'
                    }
                }
            }
        });
    </script>
    @endpush
@endsection
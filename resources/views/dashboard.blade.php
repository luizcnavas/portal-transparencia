@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1 class="mb-4 titulo">Dashboard</h1> 
    <div class="row"> 
        <div class="col-md-4"> 
            <div class="card text-white bg-danger mb-3 dashFundo"> 
                <div class="card-body"> 
                    <h5 class="card-title numero">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</h5> 
                </div> 
            </div> 
        </div> 
        <div class="col-md-4"> 
            <div class="card text-white bg-success mb-3 dashFundo"> 
                <div class="card-body"> 
                    <h5 class="card-title numero">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</h5> 
                </div> 
            </div> 
        </div> 
        <div class="col-md-4"> 
            <div class="card text-white bg-primary mb-3 dashFundo"> 
                <div class="card-body"> 
                    <h5 class="card-title numero">R$ {{ number_format($saldo, 2, ',', '.') }}</h5> 
                </div> 
            </div> 
        </div> 
    </div>

    {{-- Gráfico financeiro: representação visual de receitas vs despesas --}}
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <canvas id="financeChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('financeChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Receitas', 'Despesas'],
            datasets: [{
                label: 'Valor em R$',
                data: [{{ $totalReceitas }}, {{ $totalDespesas }}],
                backgroundColor: [
                    'rgba(25, 135, 84, 0.7)',  // Verde para receitas
                    'rgba(220, 53, 69, 0.7)'   // Vermelho para despesas
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
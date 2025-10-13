@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes</h1>

    <div class="card mb-3">
            <div class="card-body">
                {{-- Reutiliza o partial com o conteúdo detalhado --}}
                @include('transacoes._detail', ['item' => $item])

            <a href="{{ route('transacoes.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
@endsection

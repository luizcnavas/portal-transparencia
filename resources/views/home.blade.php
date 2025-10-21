@extends('layouts.app')

@section('content')
<div class="tituloHome">
    <div class="container-fluid py-5 caixaTitulo">
        <h1 class="display-5 fw-bold titulo">Bem-vindo ao Portal da Transparência da AEAPS</h1>
        <div class="caixasubtit">
            <p class="subtit">
                Este espaço é dedicado a fornecer acesso claro e aberto às informações sobre as atividades, finanças e governança da nossa associação.
            </p>
        </div>
    </div>
</div>
<div class="TodosbtnsHome">
    <div class="btnHome">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnCarteira" src="{{ asset('assets/img/botoes/btnDespesas.png') }}" alt="Imagem de carteira"/></a>
        <p class="txtbtn">Despesas</p>
    </div>
    <div class="btnHome">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnFinanceiro" src="{{ asset('assets/img/botoes/btnFinanceiro.png') }}" alt="Imagem de carteira"/></a>
        <p class="txtbtn">Financeiro</p>
    </div>
    <div class="btnHome">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnPessoal" src="{{ asset('assets/img/botoes/btnPessoa.png') }}" alt="Imagem de carteira"/></a>
        <p class="txtbtn">Pessoal</p>
    </div>
    <div class="btnHome">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnLeg" src="{{ asset('assets/img/botoes/btnLegislacao.png') }}" alt="Imagem de carteira"/></a>
        <p class="txtbtn">Legislação</p>
    </div>
    <div class="btnHome">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnReceita" src="{{ asset('assets/img/botoes/btnReceitas.png') }}" alt="Imagem de carteira"/></a>
        <p class="txtbtn">Receitas</p>
    </div>
    <div class="btnHome">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnInfo" src="{{ asset('assets/img/botoes/btnInfo.png') }}" alt="Imagem de carteira"/></a>
        <p class="txtbtn">Informações</p>
    </div>
</div>
<div class="pesquisa">
    <input type="text" placeholder="O que você procura?" class="campoPesquisa"></input>
   
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
<a href="{{ route('documentos.index') }}" class="btn btn-primary btn-lg" type="button">Ver Documentos</a>
<a href="{{ route('noticias.index') }}" class="btn btn-secondary btn-lg" type="button">Ler Notícias</a>
@endsection

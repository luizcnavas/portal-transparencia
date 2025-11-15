@extends('layouts.app')

@section('content')
<!-- Bem-vindo ao Portal -->
<div class="TitCred">
    <div class="container-fluid py-5 caixaTitulo">
        <h1 class="display-5 fw-bold tituloCred">Créditos</h1>
    </div>
</div>
<div class="InfoCred">
    <div class="projeto">
        <p class="titInfo">Projeto de Extensão:</p>
        <p class="informacao">Fábrica de Software: Desenvolvimento de Websites, Aplicativos e Jogos.</p>
    </div>
    <div class="professor">
        <p class="titInfo">Nome do Professor:</p>
        <p class="informacao">Prof. Dr. Elvio Gilberto da Silva</p>
    </div>
    <div class="integrantes">
        <p class="titInfo">Integrantes da equipe desenvolvedora:</p>
        <p class="informacao">Ana Victória Augusto de Souza</p>
        <p class="informacao">Eduarda Prado dos Santos</p>
        <p class="informacao">Felipe Lelis Zancanella R. Queiroz</p>
        <p class="informacao">Gabriela dos Santos Dourado</p>
        <p class="informacao">Luiz Carlos Navas Junior</p>
        <p class="informacao">Maria Eduarda Martin Menao</p>
        <p class="informacao">Pedro Parmegiani da Costa</p>
        <p class="informacao">Raissa Limeira Moreira Thome</p>
        <p class="informacao">Rebeca Gonçalves A. dos Santos</p>
    </div>
    <div class="apoio">
        <p class="titInfo">Apoio</p>
        <img class="logoExt" src="{{ asset('assets/img/coordenadoria-de-extensao.jpg') }}" alt="Logo Coordenadoria Extensão"/>
    </div>
</div>
@endsection


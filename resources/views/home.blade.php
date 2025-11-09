@extends('layouts.app')

@section('content')
<!-- Bem-vindo ao Portal -->
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

<!-- Campo de Pesquisa -->
<div class="pesquisa">
    <form id="searchForm" class="d-flex justify-content-center align-items-center w-100">
        <input type="text" id="searchInput" placeholder="O que você procura? (Ex: documentos, financeiro, legislação...)" class="campoPesquisa">
    </form>
</div>

<!-- Botões de Navegação -->
<div class="TodosbtnsHome">
    <div class="btnHome" data-section="documentos">
        <a href="{{ route('documentos.index') }}" type="button"><img class="btnPessoal" src="{{ asset('assets/img/botoes/btnPessoa.png') }}" alt="Documentos"/></a>
        <p class="txtbtn">Documentos</p>
    </div>
    <div class="btnHome" data-section="financeiro">
        <a href="{{ route('financeiros.index') }}" type="button"><img class="btnFinanceiro" src="{{ asset('assets/img/botoes/btnFinanceiro.png') }}" alt="Financeiro"/></a>
        <p class="txtbtn">Financeiro</p>
    </div>
    <div class="btnHome" data-section="legislacao">
        <a href="{{ route('legislacoes.index') }}" type="button"><img class="btnLeg" src="{{ asset('assets/img/botoes/btnLegislacao.png') }}" alt="Legislação"/></a>
        <p class="txtbtn">Legislação</p>
    </div>
    <div class="btnHome" data-section="informacoes">
        <a href="{{ route('informacoes.index') }}" type="button"><img class="btnInfo" src="{{ asset('assets/img/botoes/btnInfo.png') }}" alt="Informações"/></a>
        <p class="txtbtn">Informações</p>
    </div>
    <div class="btnHome" data-section="noticias">
        <a href="{{ route('noticias.index') }}" type="button"><img class="btnReceita" src="{{ asset('assets/img/botoes/btnReceitas.png') }}" alt="Notícias"/></a>
        <p class="txtbtn">Notícias</p>
    </div>
</div>

<!-- Sobre a Organização -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4" style="color: #20752b;">Sobre Nossa Organização</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="color: #20752b;">Nossa Causa</h4>
                            <p class="text-justify">
                                A AEAPS é dedicada a promover o bem-estar social e o desenvolvimento sustentável da comunidade. 
                                Trabalhamos incansavelmente para garantir acesso a recursos essenciais e oportunidades de crescimento 
                                para todos os membros de nossa sociedade.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color: #20752b;">Nossa Missão</h4>
                            <p class="text-justify">
                                Promover a transparência, ética e responsabilidade social, oferecendo serviços de qualidade 
                                e mantendo uma comunicação clara com todos os nossos parceiros e beneficiários. Nosso compromisso 
                                é com a excelência e a integridade em todas as nossas ações.
                            </p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4 style="color: #20752b;">Nossos Valores</h4>
                            <ul class="list-unstyled">
                                <li><strong>✓ Transparência:</strong> Mantemos abertas todas as informações relevantes sobre nossas atividades</li>
                                <li><strong>✓ Responsabilidade Social:</strong> Comprometidos com o impacto positivo na comunidade</li>
                                <li><strong>✓ Ética:</strong> Atuamos com integridade e respeito em todas as relações</li>
                                <li><strong>✓ Sustentabilidade:</strong> Buscamos soluções duradouras e responsáveis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    
    // Mapeamento de palavras-chave para rotas
    const searchMap = {
        'documentos': '{{ route("documentos.index") }}',
        'documento': '{{ route("documentos.index") }}',
        'financeiro': '{{ route("financeiros.index") }}',
        'financeira': '{{ route("financeiros.index") }}',
        'finanças': '{{ route("financeiros.index") }}',
        'financas': '{{ route("financeiros.index") }}',
        'receita': '{{ route("financeiros.index") }}',
        'receitas': '{{ route("financeiros.index") }}',
        'despesa': '{{ route("financeiros.index") }}',
        'despesas': '{{ route("financeiros.index") }}',
        'legislação': '{{ route("legislacoes.index") }}',
        'legislacao': '{{ route("legislacoes.index") }}',
        'lei': '{{ route("legislacoes.index") }}',
        'leis': '{{ route("legislacoes.index") }}',
        'informações': '{{ route("informacoes.index") }}',
        'informacoes': '{{ route("informacoes.index") }}',
        'informacao': '{{ route("informacoes.index") }}',
        'contato': '{{ route("informacoes.index") }}',
        'contatos': '{{ route("informacoes.index") }}',
        'notícias': '{{ route("noticias.index") }}',
        'noticias': '{{ route("noticias.index") }}',
        'noticia': '{{ route("noticias.index") }}',
        'news': '{{ route("noticias.index") }}',
        'início': '{{ route("home") }}',
        'inicio': '{{ route("home") }}',
        'home': '{{ route("home") }}'
    };
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        // Procura por correspondência exata ou parcial
        for (const [key, url] of Object.entries(searchMap)) {
            if (searchTerm.includes(key) || key.includes(searchTerm)) {
                window.location.href = url;
                return;
            }
        }
        
        // Se não encontrar, vai para documentos por padrão
        alert('Não encontramos resultados específicos. Tente: documentos, financeiro, legislação, informações ou notícias.');
    });
    
    // Enter para pesquisar
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchForm.dispatchEvent(new Event('submit'));
        }
    });
});
</script>
@endpush

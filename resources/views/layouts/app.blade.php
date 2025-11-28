<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal da Transparência - AEAPS</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/AEAPS - Vetor-02.png') }}" type="image/x-icon">
    <!-- Bootstrap 5 CSS (carregado via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
     @stack('styles')
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .footer {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light  menu">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}"><img class="logo" src="{{ asset('assets/img/LogoAEAPSBranca.png') }}" alt="Logo AEAPS" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link itemMenu"  href="{{ route('home') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link itemMenu" href="{{ route('documentos.index') }}">Documentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link itemMenu" href="{{ route('financeiros.index') }}">Financeiro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link itemMenu" href="{{ route('legislacoes.index') }}">Legislação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link itemMenu" href="{{ route('informacoes.index') }}">Informações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link itemMenu" href="{{ route('noticias.index') }}">Notícias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link itemMenu" href="{{ route('pessoal.index') }}">Pessoal</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link itemMenu" href="{{ route('login') }}">Login</a>
                            </li>
                        @endguest
                        @auth
                            <li class="nav-item">
                                <a class="nav-link itemMenu" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link itemMenu">Logout</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="rodapeCompleto">
            <div class="CaixaRodape">
                <div class="contatoR">
                    <p class="titRodape">Nosso Contato</p>
                    <hr class="linhaR"/>
                    <p class="subtitR">Endereço</p>
                    <p class="InfoR">Rua Julio Prestes, 2-53, Centro - Bauru-SP</p>
                    <p class="subtitR">Ligue para nós</p>
                    <p class="InfoR">(14) 3879-4204</p>
                    <p class="subtitR">Email</p>
                    <p class="InfoR">contato@aeasp.org.br</p>
                </div>
                <div class="linksR">
                    <p class="titRodape">Links Rápidos</p>
                    <hr class="linhaR"/>
                    <a class="linkRodape"  href="{{ route('home') }}">Início</a>
                    <a class="linkRodape" href="{{ route('documentos.index') }}">Documentos</a>
                    <a class="linkRodape" href="{{ route('financeiros.index') }}">Informações financeiras</a>
                    <a class="linkRodape" href="{{ route('legislacoes.index') }}">Informações Legais</a>
                    <a class="linkRodape" href="{{ route('noticias.index') }}">Notícias</a>
                </div>
                <div class="pesquisaR">
                    <p class="titRodape">O que você procura?</p>
                    <hr class="linhaR"/>
                    <p class="InfoR">Digite no campo o que busca</p>
                    <form id="footerSearchForm" class="d-flex w-100 pesquisa">
                        <input type="text" id="footerSearchInput" placeholder="(Ex: documentos, financeiro, legislação...)" class="campoPesquisaR">
                        <button type="submit" class="Busca">Buscar</button>
                    </form>
                </div>
            </div>
            <div class="container text-center rodapeIni">
                <span class="text-muted direitosR">© 2025 AEAPS. Todos os direitos reservados. </span>
                <a class="nav-link"  href="{{ route('creditos.index') }}" style="color: #adf3af; text-decoration: underline;" >Créditos</a>
            </div>
        </div>
    </footer>
        <!-- Bootstrap 5 JS (bundle com Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script de Busca do Rodapé -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const footerSearchInput = document.getElementById('footerSearchInput');
        const footerSearchForm = document.getElementById('footerSearchForm');
        
        if (footerSearchForm && footerSearchInput) {
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
                'home': '{{ route("home") }}',
                'pessoal': '{{ route("pessoal.index") }}',
                'pessoa': '{{ route("pessoal.index") }}',
                'diretoria': '{{ route("pessoal.index") }}',
                'direção': '{{ route("pessoal.index") }}',
                'direcao': '{{ route("pessoal.index") }}'
            };
            
            footerSearchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = footerSearchInput.value.toLowerCase().trim();
                
                if (!searchTerm) {
                    alert('Por favor, digite algo para buscar.');
                    return;
                }
                
                // Procura por correspondência exata ou parcial
                for (const [key, url] of Object.entries(searchMap)) {
                    if (searchTerm.includes(key) || key.includes(searchTerm)) {
                        window.location.href = url;
                        return;
                    }
                }
                
                // Se não encontrar, mostra alerta
                alert('Não encontramos resultados específicos. Tente: documentos, financeiro, legislação, informações, pessoal ou notícias.');
            });
            
            // Enter para pesquisar
            footerSearchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    footerSearchForm.dispatchEvent(new Event('submit'));
                }
            });
        }
    });
    </script>
    
    @stack('scripts')
</body>
</html>
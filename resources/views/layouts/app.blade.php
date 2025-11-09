<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal da Transparência - AEAPS</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/AEAPS-Vetor-02.png') }}" type="image/x-icon">
    <!-- Bootstrap 5 CSS (carregado via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
                <a class="navbar-brand" href="{{ route('home') }}"><img class="logo" src="{{ asset('assets/img/LogoAEAPS-Branca.png') }}" alt="Logo AEAPS" /></a>
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
        <div class="container text-center">
            <span class="text-muted">© 2025 AEAPS. Todos os direitos reservados.</span>
        </div>
    </footer>

        <!-- Bootstrap 5 JS (bundle com Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- fonte do google -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

        <!-- CSS bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

        <!-- CSS da aplicação -->
        <link rel="stylesheet" href="/css/styles.css">

        <!-- JS da aplicação -->
        <script src="/js/scripts.js"></script>

    <body>

        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbar">

                    <a href="/" class="navbar-brand">
                        <img src="/img/hdcevents_logo.svg" alt="HDC Events">
                    </a>

                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a href="/" class="nav-link">Eventos</a>
                        </li>

                        <li class="nav-item">
                            <a href="/events/create" class="nav-link">Criar Eventos</a>
                        </li>

                        @auth
                        <!-- links para quando eu estiver autenticado(logado) no sistema -->

                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link">Meus eventos</a>
                            </li>

                            <!-- logout -->
                            <li class="nav-item">
                                <form action="/logout" method="POST">

                                    @csrf

                                    <a href="/logout"
                                        class="nav-link"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();">                                        
                                        Sair
                                    </a>

                                </form>
                            </li>

                        @endauth

                        @guest
                        <!-- alteração na barra de navegação quando o usuário estiver logado ou não -->
                        <!-- se eu não estiver logado aparece as opções abaixo, caso contrario não aparece -->

                            <li class="nav-item">
                                <a href="/login" class="nav-link">Entrar</a>
                            </li>

                            <li class="nav-item">
                                <a href="/register" class="nav-link">Cadastrar</a>
                            </li>

                        @endguest

                    </ul>

                </div>
            </nav>
        </header>

        <main>
            <div class="container-fluid">
                <div class="row">
                    <!-- usando flash message -->
                    @if (session('msg'))
                        <p class="msg">{{ session('msg') }}</p>
                    @endif

                    @yield('content')

                </div>
            </div>
        </main>

        <footer>
            <p>HDC Events &copy; 2022</p>
        </footer>

        <!-- ion icons -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    </body>
</html>
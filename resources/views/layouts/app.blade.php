<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Suivi de stage BUT</title>

    <!-- Scripts -->
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
    <script src="{{ asset('js/loading.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if(Route::currentRouteName() == "login")
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tuteur.css') }}" rel="stylesheet">
    <link href="{{ asset('css/etudiant.css') }}" rel="stylesheet">
</head>

<body <?= (Route::is('login') ? 'class="bg-login"' : '') ?> >

    <div id="app">
        @if( isset($_SESSION['name']))
        <nav class="navbar navbar-expand-md navbar-dark bg-secondary shadow-sm" role="navigation">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Suivi de stage BUT
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="d-none d-md-block" style="color: #fff !important; font-size:20px; margin-right:20px;">
                    |
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if( isset($_SESSION['role']) && $_SESSION['role'] == 'responsable')
                        <li class="nav-item <?= Route::currentRouteName() == "listeSessions" ? 'nav-activ' : '' ?>">
                            <a class="nav-link" href="{{ route('listeSessions') }}">{{ __('Liste des sessions') }}</a>
                        </li>
                        <li class="nav-item <?= Route::currentRouteName() == "listeTuteurs" ? 'nav-activ' : '' ?>">
                            <a class="nav-link" href="{{ route('listeTuteurs') }}">{{ __('Liste des tuteurs') }}</a>
                        </li>
                        @elseif( isset($_SESSION['role']) && $_SESSION['role'] == 'tuteur')
                        <li class="nav-item <?= Route::currentRouteName() == "listeSessionsTuteur" ? 'nav-activ' : '' ?>">
                            <a class="nav-link" href="{{ route('listeSessionsTuteur') }}">{{ __('Liste des sessions') }}</a>
                        </li>
                        @elseif( isset($_SESSION['role']) && $_SESSION['role'] == 'etudiant')
                        <li class="nav-item <?= Route::currentRouteName() == "sessions" ? 'nav-activ' : '' ?>">
                            <a class="nav-link" href="{{ route('sessions', ['numEtudiant'=> $_SESSION['num']]) }}">{{ __('Liste de mes sessions') }}</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (isset($_SESSION['name']))
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?= (isset($_SESSION['num']) ? $_SESSION['num'] : $_SESSION['name']) ?>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                                    @if(isset($_SESSION['num']))
                                    <a class="dropdown-item">
                                        <strong>{{ $_SESSION['name'] }}</strong>
                                    </a>
                                    <hr>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('account') }}">
                                        {{ __('Mon compte') }}
                                    </a>
                                    <hr>
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        {{ __('Se déconnecter') }}
                                    </a>
                                </div>
                                <i class="bi-alarm"></i>
                            </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Se connecter') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?= $_SESSION['name'] ?>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        {{ __('Se déconnecter') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endif
        <main role="main" class="py-4">
            @yield('content')
        </main>
<!--
        <footer role="contentinfo" class="container">
            <div class="row">
                <div class="col-md-3">
                    <p class="titreFooter">Mon Compte</p>
                    <ul>
                        <li><a href="">Connection</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <p class="titreFooter">Sessions</p>
                    <ul>
                        <li><a href="">Connection</a></li>
                    </ul>
                </div>
            </div>
        </footer>-->
    </div>
</body>
</html>

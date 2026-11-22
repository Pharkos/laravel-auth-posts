{{-- ==================================================
     NAVBAR (Bootstrap)
     Su mobile i link si chiudono nel pulsante "hamburger"
     ================================================== --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        {{-- Nome del sito --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Auth &amp; Posts</a>

        {{-- Pulsante hamburger (visibile solo su schermi piccoli) --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Apri il menu"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            {{-- Link principali (a sinistra) --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    {{-- @class aggiunge 'active' solo se siamo su quella pagina --}}
                    <a @class(['nav-link', 'active' => request()->routeIs('home')]) href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('about')]) href="{{ route('about') }}">
                        Chi sono
                    </a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('posts.index', 'posts.show')]) href="{{ route('posts.index') }}">
                        Post
                    </a>
                </li>
            </ul>

            {{-- Link dell'utente (a destra) --}}
            <ul class="navbar-nav">

                @auth
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('posts.create')]) href="{{ route('posts.create') }}">
                            + Nuovo post
                        </a>
                    </li>

                    {{-- Menu a tendina del profilo --}}
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text small text-muted">
                                    {{ auth()->user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Il mio profilo</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.posts') }}">I miei post</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.information') }}">Dati personali</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                {{-- Logout: sempre con POST + CSRF, mai con un semplice link --}}
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Esci
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('login')]) href="{{ route('login') }}">
                            Accedi
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary btn-sm mt-1" href="{{ route('register') }}">
                            Registrati
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{-- La partial eredita già le variabili della pagina ($pageTitle, $metaDescription) --}}
@include('partials.head')

{{-- d-flex flex-column min-vh-100: il footer resta in fondo anche nelle pagine corte --}}
<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Barra di navigazione --}}
    @include('partials.menu')

    {{-- Contenuto principale della pagina --}}
    <main class="container py-4 flex-grow-1">

        {{-- Messaggi flash (successo, errore...) --}}
        @include('partials.messages')

        @yield('content')

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} Laravel Auth &amp; Posts
        </div>
    </footer>

</body>

</html>
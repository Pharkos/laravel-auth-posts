@extends('layouts.app')

@section('content')

<div class="col-xl-10 mx-auto">

    {{-- ================= HERO: chi sono ================= --}}
    <section class="card shadow-sm border-0 mb-5">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">

                {{-- Avatar con le iniziali --}}
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-2 flex-shrink-0"
                     style="width: 96px; height: 96px;">
                    VP
                </div>

                <div>
                    <h1 class="h2 fw-bold mb-1">Vakhtang Pharkosadze</h1>
                    <p class="text-primary fw-semibold mb-2">Sviluppatore web full-stack junior</p>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-geo-alt"></i> Genova, Italia
                    </p>
                    <p class="mb-4">
                        Ho realizzato questo progetto per mettere in pratica le basi di un'applicazione
                        web reale. Mi piace capire come e perché funziona il codice, non solo farlo funzionare.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        {{-- rel="noopener": la nuova scheda non può controllare questa pagina --}}
                        <a href="https://github.com/Pharkos" class="btn btn-dark" target="_blank" rel="noopener">
                            <i class="bi bi-github me-1"></i> Profilo GitHub
                        </a>
                        <a href="https://github.com/Pharkos/laravel-auth-posts" class="btn btn-outline-dark" target="_blank" rel="noopener">
                            <i class="bi bi-code-slash me-1"></i> Codice del progetto
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================= FUNZIONALITÀ ================= --}}
    <section class="mb-5">
        <h2 class="h4 mb-4">Cosa fa l'applicazione</h2>

        @php
            // Ogni funzionalità: [icona Bootstrap, titolo, descrizione]
            $features = [
                ['bi-shield-lock', 'Autenticazione', 'Registrazione, login e logout, con limite ai tentativi di accesso.'],
                ['bi-journal-text', 'Gestione post', 'Creazione, modifica ed eliminazione dei post, con paginazione.'],
                ['bi-image', 'Immagini', 'Upload facoltativo con validazione e cancellazione dei file non più usati.'],
                ['bi-person-check', 'Permessi', 'Con le Policy solo l\'autore può modificare o eliminare i propri post.'],
                ['bi-person-gear', 'Area profilo', 'Modifica di nome, email e password con verifica della password attuale.'],
                ['bi-check2-circle', 'Test automatici', 'Test PHPUnit per autenticazione, post, immagini e profilo.'],
            ];
        @endphp

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($features as [$icon, $title, $text])
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="rounded-3 bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 48px; height: 48px;">
                                <i class="bi {{ $icon }} fs-4"></i>
                            </div>
                            <h3 class="h6 fw-bold">{{ $title }}</h3>
                            <p class="text-muted small mb-0">{{ $text }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================= TECNOLOGIE + PROCESSO ================= --}}
    <div class="row g-4">

        <div class="col-lg-6">
            <section class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">Tecnologie</h2>

                    @php
                        $stack = [
                            'Backend' => ['PHP', 'Laravel 12', 'Eloquent', 'MariaDB'],
                            'Frontend' => ['Blade', 'Bootstrap 5', 'Vite'],
                            'Strumenti' => ['PHPUnit', 'Pint', 'Git', 'GitHub'],
                        ];
                    @endphp

                    @foreach ($stack as $group => $techs)
                        <p class="small text-muted text-uppercase fw-semibold mb-2">{{ $group }}</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach ($techs as $tech)
                                <span class="badge rounded-pill text-bg-light border px-3 py-2">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="col-lg-6">
            <section class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">Come è stato sviluppato</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex gap-3 mb-3">
                            <i class="bi bi-git text-primary fs-5"></i>
                            <span>Un branch per ogni attività e pull request su GitHub prima del merge.</span>
                        </li>
                        <li class="d-flex gap-3 mb-3">
                            <i class="bi bi-chat-left-text text-primary fs-5"></i>
                            <span>Commit piccoli e descrittivi secondo le Conventional Commits.</span>
                        </li>
                        <li class="d-flex gap-3 mb-3">
                            <i class="bi bi-check2-all text-primary fs-5"></i>
                            <span>Test eseguiti dopo ogni modifica, insieme alle prove nel browser.</span>
                        </li>
                        <li class="d-flex gap-3">
                            <i class="bi bi-lightbulb text-primary fs-5"></i>
                            <span>Ogni scelta tecnica verificata con la documentazione ufficiale di Laravel.</span>
                        </li>
                    </ul>
                </div>
            </section>
        </div>

    </div>

</div>

@endsection
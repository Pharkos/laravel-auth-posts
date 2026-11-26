@extends('layouts.app')

@section('content')

<div class="col-xl-10 mx-auto">

    {{-- ================= INTESTAZIONE ================= --}}
    <section class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 d-flex align-items-center gap-3">

            {{-- Avatar con l'iniziale del nome --}}
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-3 flex-shrink-0"
                 style="width: 64px; height: 64px;">
                {{ Str::upper(Str::substr($currentUser->name, 0, 1)) }}
            </div>

            <div>
                <h1 class="h4 mb-1">Ciao, {{ $currentUser->name }}!</h1>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar3"></i>
                    Iscritto dal {{ $currentUser->created_at->format('d/m/Y') }}
                </p>
            </div>

        </div>
    </section>

    {{-- ================= STATISTICHE E AZIONI RAPIDE ================= --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">

        {{-- Numero dei post --}}
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <p class="text-muted small mb-1">Post pubblicati</p>
                    <p class="display-6 fw-bold mb-0">{{ $postsCount }}</p>
                </div>
            </div>
        </div>

        @php
            // Azioni rapide: [rotta, icona, titolo]
            $actions = [
                ['posts.create', 'bi-plus-circle', 'Nuovo post'],
                ['profile.posts', 'bi-journal-text', 'I miei post'],
                ['profile.information', 'bi-person-gear', 'Dati personali'],
            ];
        @endphp

        @foreach ($actions as [$route, $icon, $label])
            <div class="col">
                {{-- stretched-link: rende cliccabile l'intera card --}}
                <div class="card shadow-sm border-0 h-100 position-relative">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <i class="bi {{ $icon }} fs-3 text-primary"></i>
                        <a href="{{ route($route) }}" class="stretched-link text-decoration-none text-reset fw-semibold">
                            {{ $label }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- ================= ULTIMI POST DELL'UTENTE ================= --}}
    <section class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h2 class="h6 mb-0">I tuoi ultimi post</h2>
            <a href="{{ route('profile.posts') }}" class="small">Vedi tutti →</a>
        </div>

        <ul class="list-group list-group-flush">
            @forelse ($latestPosts as $post)
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                        {{ $post->title }}
                    </a>
                    <span class="text-muted small text-nowrap ms-3">
                        {{ $post->created_at->format('d/m/Y') }}
                    </span>
                </li>
            @empty
                <li class="list-group-item py-4 text-center text-muted">
                    Non hai ancora pubblicato post.
                    <a href="{{ route('posts.create') }}">Scrivi il primo</a>
                </li>
            @endforelse
        </ul>
    </section>

</div>

@endsection
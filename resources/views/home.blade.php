@extends('layouts.app')

@section('content')

{{-- Hero: presentazione del progetto --}}
<section class="bg-white rounded-3 shadow-sm p-4 p-md-5 mb-5">
    <h1 class="display-6 fw-bold mb-3">Laravel Auth &amp; Posts</h1>

    <p class="lead text-muted mb-4">
        Un piccolo blog sviluppato con Laravel 12: registrazione e login,
        gestione dei post con immagini, permessi tramite Policy e test automatici.
    </p>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('posts.index') }}" class="btn btn-primary">Vedi tutti i post</a>

        {{-- Il secondo pulsante cambia in base allo stato dell'utente --}}
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-outline-primary">+ Nuovo post</a>
        @endauth

        @guest
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Registrati</a>
        @endguest
    </div>
</section>

{{-- Ultimi post pubblicati --}}
<section>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Ultimi post</h2>
        <a href="{{ route('posts.index') }}" class="small">Vedi tutti →</a>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        {{-- @forelse: come @foreach, ma con un blocco @empty se non ci sono post --}}
        @forelse ($latestPosts as $post)
            <div class="col">
                <x-post-card :post="$post" />
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">Non ci sono ancora post.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection
@extends('layouts.app')

@section('content')

    {{-- Torna alla lista dei post --}}
    <a href="{{ route('posts.index') }}" class="btn btn-link px-0 mb-3">
        ← Torna ai post
    </a>

    {{-- col-lg-8 mx-auto: testo centrato e non troppo largo, più facile da leggere --}}
    <article class="card shadow-sm col-lg-8 mx-auto">

        {{-- Mostriamo solo un'immagine vera, non il placeholder.
             object-fit: contain → l'immagine si vede intera, senza tagli --}}
        @if ($post->image)
            <img
                src="{{ $post->image_url }}"
                alt="{{ $post->title }}"
                class="card-img-top bg-light"
                style="max-height: 450px; object-fit: contain;"
            >
        @endif

        <div class="card-body p-4">

            <h1 class="h2 card-title">{{ $post->title }}</h1>

            {{-- Autore e data di pubblicazione --}}
            <p class="text-muted small mb-4">
                di <strong>{{ $post->user->name }}</strong>
                · {{ $post->created_at->format('d/m/Y') }}
            </p>

            {{-- Mostra il contenuto mantenendo gli "a capo" inseriti dall'utente --}}
            <div class="card-text">
                {!! nl2br(e($post->content)) !!}
            </div>

        </div>

        {{-- Azioni: visibili solo all'autore (PostPolicy) --}}
        @canany(['update', 'delete'], $post)
            <div class="card-footer bg-white d-flex gap-2 p-3">

                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary btn-sm">
                        Modifica
                    </a>
                @endcan

                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        {{-- Laravel trasforma la richiesta POST in DELETE --}}
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            Elimina
                        </button>
                    </form>
                @endcan

            </div>
        @endcanany

    </article>

@endsection
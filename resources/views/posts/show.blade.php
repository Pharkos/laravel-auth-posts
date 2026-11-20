@extends('layouts.app')

@section('content')

<div class="container">

    {{-- Ritorna alla lista dei post --}}
    <a href="{{ route('posts.index') }}" class="btn">
        ← Torna alla lista
    </a>

    {{-- Nella pagina del post mostriamo solo un'immagine vera, non il placeholder.
         object-fit: contain → l'immagine si vede intera, senza tagli --}}
    @if ($post->image)
        <img
            src="{{ $post->image_url }}"
            alt="{{ $post->title }}"
            class="img-fluid rounded mb-3 d-block mx-auto"
            style="max-height: 500px; object-fit: contain;"
        >
    @endif

    <h2>{{ $post->title }}</h2>

    <p>
        <b>Autore:</b> {{ $post->user->name }}
    </p>

    {{-- Mostra il contenuto mantenendo gli "a capo" inseriti dall'utente --}}
    <div style="margin-top:20px">
        {!! nl2br(e($post->content)) !!}
    </div>

    <hr>

    @can('update', $post)
        {{-- Modifica del post --}}
        <a class="btn" href="{{ route('posts.edit', $post->id) }}">
            Modifica Post
        </a>
    @endcan

    @can('delete', $post)
        {{-- Eliminazione del post --}}
        <form
            action="{{ route('posts.destroy', $post->id) }}"
            method="POST"
            style="display:inline"
        >
            @csrf

            {{-- Laravel trasforma la richiesta POST in DELETE --}}
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Elimina
            </button>
        </form>
    @endcan

</div>

@endsection
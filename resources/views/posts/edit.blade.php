@extends('layouts.app')

@section('content')

<div class="col-lg-8 mx-auto">

    {{-- Torna al dettaglio del post --}}
    <a href="{{ route('posts.show', $post) }}" class="btn btn-link px-0 mb-3">
        ← Torna al post
    </a>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="h3 mb-4">Modifica post</h1>

            {{-- enctype necessario per inviare il file dell'immagine --}}
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Laravel trasforma la richiesta POST in PUT --}}
                @method('PUT')

                @include('posts.partials.form')

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary">Annulla</a>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection
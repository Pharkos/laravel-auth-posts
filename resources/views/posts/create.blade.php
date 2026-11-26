@extends('layouts.app')

@section('content')

<div class="col-lg-8 mx-auto">

    {{-- Torna alla lista dei post --}}
    <a href="{{ route('posts.index') }}" class="btn btn-link px-0 mb-3">
        ← Torna ai post
    </a>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="h3 mb-4">Nuovo post</h1>

            {{-- enctype necessario per inviare il file dell'immagine --}}
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('posts.partials.form')

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Pubblica</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Annulla</a>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection
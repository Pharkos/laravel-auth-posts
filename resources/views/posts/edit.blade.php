@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Modifica Post</h2>

    {{-- enctype multipart/form-data: obbligatorio per inviare file --}}
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">

        @csrf

        {{-- Laravel trasforma la richiesta POST in PUT --}}
        @method('PUT')

        titolo:
        <input
            type="text"
            name="title"
            value="{{ old('title', $post->title) }}"
            required
        >
        <br><br>

        contenuto:
        <textarea name="content" required>{{ old('content', $post->content) }}</textarea>
        <br><br>

        {{-- Immagine attuale: la mostriamo solo se il post ne ha una --}}
        @if ($post->image)
            <p>Immagine attuale:</p>
            <img
                src="{{ $post->image_url }}"
                alt="{{ $post->title }}"
                style="max-width: 200px; height: auto;"
            >
            <br><br>
        @endif

        {{-- Nuova immagine (facoltativa): se non si sceglie un file, resta quella attuale --}}
        Nuova immagine (facoltativa):
        <input type="file" name="image" accept="image/*">

        @error('image')
            <p style="color:red">{{ $message }}</p>
        @enderror
        <br><br>

        <button class="btn" type="submit">
            Aggiorna
        </button>

    </form>

</div>

@endsection
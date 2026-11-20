@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Crea il tuo post</h2>

    {{-- enctype multipart/form-data: obbligatorio per inviare file, altrimenti arriva solo il nome --}}
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        titolo:
        <input type="text" name="title" value="{{ old('title') }}" required>
        <br>

        Contenuto:
        <textarea name="content" required>{{ old('content') }}</textarea>
        <br>

        {{-- Immagine facoltativa: 'accept' è solo un aiuto per il browser,
             il vero controllo lo fa PostRequest --}}
        Immagine (facoltativa):
        <input type="file" name="image" accept="image/*">

        @error('image')
            <p style="color:red">{{ $message }}</p>
        @enderror
        <br>

        <button type="submit" class="btn">
            Salva Post
        </button>

    </form>

</div>

@endsection
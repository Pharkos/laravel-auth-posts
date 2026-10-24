@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Modifica Post</h2>

    <form action="{{ route('post.update', $post->id) }}" method="POST">

        @csrf

        {{-- Laravel trasforma la richiesta POST in PUT --}}
        @method('PUT')

        titolo:
        <input
            type="text"
            name="title"
            value="{{ $post->title }}"
            required
        >
        <br><br>

        contenuto:
        <textarea name="content" required>{{ $post->content }}</textarea>
        <br><br>

        <button class="btn" type="submit">
            Aggiorna
        </button>

    </form>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Crea il tuo post</h2>

    <form action="{{ route('post.store') }}" method="POST">

        @csrf

        titolo:
        <input type="text" name="title" required>
        <br>

        Contenuto:
        <textarea name="content" required></textarea>
        <br>

        <button type="submit" class="btn">
            Salva Post
        </button>

    </form>

</div>

@endsection
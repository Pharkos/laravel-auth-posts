@extends('layouts.app')

@section('content')

<div class="container">

    {{-- Ritorna alla lista dei post --}}
    <a href="{{ route('post.index') }}" class="btn">
        ← Torna alla lista
    </a>

    <h2>{{ $post->title }}</h2>

    <p>
        <b>Autore:</b> {{ $post->user->name }}
    </p>

    {{-- Mostra il contenuto mantenendo gli "a capo" inseriti dall'utente --}}
    <div style="margin-top:20px">
        {!! nl2br(e($post->content)) !!}
    </div>

    <hr>
    @can('update' , $post)
    
    {{-- Modifica del post --}}
    <a class="btn" href="{{ route('post.edit', $post->id) }}">
        Modifica Post
    </a>

    @endcan

    {{-- Eliminazione del post --}}

    @can('delete' , $post)
    <form
        action="{{ route('post.destroy', $post->id) }}"
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
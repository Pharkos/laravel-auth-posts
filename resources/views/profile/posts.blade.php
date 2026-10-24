@extends('layouts.app')

@section('content')

<div class="container">

    {{-- Torna alla Dashboard del profilo --}}
    <a href="{{ route('profile') }}" class="btn">
        ← Torna al profilo
    </a>

    <h1>My Posts</h1>

    @if ($posts->isEmpty())

        <p>Non hai ancora creato nessun post .</p>

    @else

        <ul>

            @foreach ($posts as $post)

                <li class="post-item">

                    <h3>{{ $post->title }}</h3>

                    <p>{{ Str::limit($post->content, 50) }}</p>

                    {{-- Apre il post completo --}}
                    <a href="{{ route('post.show', $post->id) }}">
                        Leggi post completo
                    </a>

                </li>

            @endforeach

        </ul>

    @endif

</div>

@endsection
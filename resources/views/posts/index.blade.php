@extends('layouts.app')

@section('content')

    {{-- Intestazione: titolo + pulsante "Nuovo post" (solo per utenti loggati) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Post</h1>

        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                + Nuovo post
            </a>
        @endauth
    </div>

    @if ($posts->isEmpty())

        <div class="alert alert-light border text-center">
            Non ci sono ancora post.
        </div>

    @else

        {{-- Griglia responsive: 1 colonna su mobile, 2 su tablet, 3 su desktop.
             g-4 = spazio uniforme tra le card --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($posts as $post)
                <div class="col">
                    <x-post-card :post="$post" />
                </div>
            @endforeach
        </div>

        {{-- Link di navigazione tra le pagine (1, 2, 3...) --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    @endif

@endsection
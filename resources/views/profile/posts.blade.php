@extends('layouts.app')

@section('content')

    {{-- Intestazione: torna al profilo + titolo --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">I miei post</h1>

        <a href="{{ route('profile') }}" class="btn btn-outline-secondary btn-sm">
            ← Torna al profilo
        </a>
    </div>

    @if ($posts->isEmpty())

        <div class="alert alert-light border text-center">
            Non hai ancora creato nessun post.
            <a href="{{ route('posts.create') }}">Scrivi il primo!</a>
        </div>

    @else

        {{-- Stessa griglia e stessa card della lista dei post (componente riutilizzato) --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($posts as $post)
                <div class="col">
                    <x-post-card :post="$post" />
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    @endif

@endsection
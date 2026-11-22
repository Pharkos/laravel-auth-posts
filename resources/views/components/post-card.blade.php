{{-- ==================================================
     COMPONENTE: card di un post
     Uso: <x-post-card :post="$post" />
     Usato nella lista dei post e in "I miei post"
     ================================================== --}}

{{-- @props: il dato che il componente riceve dall'esterno --}}
@props(['post'])

{{-- h-100: tutte le card della stessa riga hanno la stessa altezza --}}
<div class="card h-100 shadow-sm">

    {{-- Immagine del post (o placeholder) con altezza fissa --}}
    <img
        src="{{ $post->image_url }}"
        class="card-img-top"
        alt="{{ $post->title }}"
        style="height: 200px; object-fit: cover;"
    >

    {{-- d-flex flex-column: il pulsante resta sempre in fondo alla card --}}
    <div class="card-body d-flex flex-column">

        <h5 class="card-title">{{ $post->title }}</h5>

        {{-- Autore e data di pubblicazione --}}
        <p class="card-text text-muted small mb-2">
            {{ $post->user->name }} · {{ $post->created_at->format('d/m/Y') }}
        </p>

        <p class="card-text flex-grow-1">
            {{ Str::limit($post->content, 100) }}
        </p>

        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary btn-sm align-self-start">
            Leggi tutto
        </a>
    </div>
</div>
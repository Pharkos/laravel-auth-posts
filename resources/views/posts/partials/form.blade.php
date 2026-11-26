{{-- Campi comuni ai form di creazione e modifica del post --}}

{{-- Titolo --}}
<div class="mb-3">
    <label for="title" class="form-label">Titolo</label>
    <input
        type="text"
        id="title"
        name="title"
        value="{{ old('title', $post->title ?? '') }}"
        class="form-control @error('title') is-invalid @enderror"
        maxlength="255"
        required
    >
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Contenuto --}}
<div class="mb-3">
    <label for="content" class="form-label">Contenuto</label>
    <textarea
        id="content"
        name="content"
        rows="8"
        class="form-control @error('content') is-invalid @enderror"
        required
    >{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Immagine attuale: solo in modifica e solo se il post ne ha una --}}
@if (isset($post) && $post->image)
    <div class="mb-3">
        <p class="form-label mb-2">Immagine attuale</p>
        <img
            src="{{ $post->image_url }}"
            alt="{{ $post->title }}"
            class="img-thumbnail"
            style="max-height: 150px;"
        >
    </div>
@endif

{{-- Nuova immagine (facoltativa) --}}
<div class="mb-4">
    <label for="image" class="form-label">
        {{ isset($post) && $post->image ? 'Sostituisci immagine' : 'Immagine' }}
        <span class="text-muted">(facoltativa)</span>
    </label>
    <input
        type="file"
        id="image"
        name="image"
        accept="image/jpeg,image/png,image/webp"
        class="form-control @error('image') is-invalid @enderror"
    >
    <div class="form-text">JPG, PNG o WEBP, massimo 2 MB.</div>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
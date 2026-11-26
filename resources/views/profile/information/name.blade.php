@extends('layouts.app')

@section('content')

<div class="col-md-8 col-lg-6 mx-auto">

    {{-- Torna alla pagina delle informazioni personali --}}
    <a href="{{ route('profile.information') }}" class="btn btn-link px-0 mb-3">
        ← Torna ai dati personali
    </a>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="h4 mb-4">Modifica nome</h1>

            <form action="{{ route('profile.information.name.update') }}" method="POST">
                @csrf

                {{-- Laravel trasforma la richiesta POST in PATCH --}}
                @method('PATCH')

                <div class="mb-4">
                    <label for="name" class="form-label">Nuovo nome</label>
                    {{-- 'is-invalid' colora il campo di rosso se c'è un errore di validazione --}}
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $currentUser->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        autocomplete="name"
                        maxlength="255"
                        required
                        autofocus
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salva</button>
                    <a href="{{ route('profile.information') }}" class="btn btn-outline-secondary">Annulla</a>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="col-md-8 col-lg-6 mx-auto">

    {{-- Torna alla pagina delle informazioni personali --}}
    <a href="{{ route('profile.information') }}" class="btn btn-link px-0 mb-3">
        ← Torna ai dati personali
    </a>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="h4 mb-2">Modifica email</h1>
            <p class="text-muted small mb-4">
                Email attuale: <strong>{{ $currentUser->email }}</strong>
            </p>

            <form action="{{ route('profile.information.email.update') }}" method="POST">
                @csrf

                {{-- Laravel trasforma la richiesta POST in PATCH --}}
                @method('PATCH')

                <div class="mb-4">
                    <label for="email" class="form-label">Nuova email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $currentUser->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        autocomplete="email"
                        required
                        autofocus
                    >
                    {{-- Errore sotto il campo (es. email già usata da un altro utente) --}}
                    @error('email')
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
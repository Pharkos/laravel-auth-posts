@extends('layouts.app')

@section('content')

<div class="col-md-8 col-lg-6 mx-auto">

    {{-- Torna alla pagina delle informazioni personali --}}
    <a href="{{ route('profile.information') }}" class="btn btn-link px-0 mb-3">
        ← Torna ai dati personali
    </a>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h1 class="h4 mb-4">Modifica password</h1>

            <form action="{{ route('profile.information.password.update') }}" method="POST">
                @csrf

                {{-- Laravel trasforma la richiesta POST in PATCH --}}
                @method('PATCH')

                {{-- Password attuale: verificata dalla regola 'current_password' --}}
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password attuale</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        autocomplete="current-password"
                        required
                        autofocus
                    >
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nuova password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Nuova password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="new-password"
                        required
                    >
                    <div class="form-text">Almeno 8 caratteri.</div>
                    {{-- Errore sulla nuova password (es. troppo corta o conferma diversa) --}}
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Conferma della nuova password (regola 'confirmed') --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Conferma nuova password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        autocomplete="new-password"
                        required
                    >
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
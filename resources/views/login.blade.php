@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h1 class="h3 mb-4 text-center">Accedi</h1>

                <form action="{{ route('login.store') }}" method="POST">
                    {{-- Token CSRF: protegge il form da richieste inviate da altri siti --}}
                    @csrf

                    {{-- Email: old() mantiene il valore se il login fallisce --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            autocomplete="email"
                            required
                            autofocus
                        >
                        {{-- Qui compare anche "Credenziali non valide": messaggio generico
                             per non rivelare se l'email esiste (user enumeration) --}}
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password: mai ripopolata con old() per sicurezza --}}
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="current-password"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Accedi</button>
                </form>

                <p class="text-center text-muted small mt-3 mb-0">
                    Non hai un account?
                    <a href="{{ route('register') }}">Registrati</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection
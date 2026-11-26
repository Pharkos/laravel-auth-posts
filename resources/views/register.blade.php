@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h1 class="h3 mb-4 text-center">Crea un account</h1>

                <form action="{{ route('register.store') }}" method="POST">
                    {{-- Token CSRF: protegge il form da richieste inviate da altri siti --}}
                    @csrf

                    {{-- Nome --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            autocomplete="name"
                            required
                            autofocus
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
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
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password: mai ripopolata con old() per sicurezza --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="new-password"
                            required
                        >
                        <div class="form-text">Almeno 8 caratteri.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Il nome password_confirmation è richiesto dalla regola "confirmed" --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Conferma password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Registrati</button>
                </form>

                <p class="text-center text-muted small mt-3 mb-0">
                    Hai già un account?
                    <a href="{{ route('login') }}">Accedi</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection
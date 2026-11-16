@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Change Password</h1>


    {{-- ==================================================
         CHANGE PASSWORD FORM
         ================================================== --}}

    <form action="{{ route('profile.information.password.update') }}" method="POST">

        @csrf

        {{-- Laravel trasforma la richiesta POST in PATCH --}}
        @method('PATCH')

        {{-- Password attuale --}}
        <label for="current_password" class="form-label">
            Current Password
        </label>

        <input
            type="password"
            id="current_password"
            name="current_password"
            class="form-control @error('current_password') is-invalid @enderror"
            required
        >

        {{-- Errore se la password attuale non è corretta --}}
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <br>

        {{-- Nuova password --}}
        <label for="password" class="form-label">
            New Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            required
        >

        {{-- Errore sulla nuova password (es. troppo corta o conferma diversa) --}}
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <br>

        {{-- Conferma della nuova password (regola 'confirmed') --}}
        <label for="password_confirmation" class="form-label">
            Confirm New Password
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-control"
            required
        >

        <br>

        <button type="submit">
            Update Password
        </button>

    </form>


    {{-- Torna alla pagina delle informazioni personali --}}
    <a href="{{ route('profile.information') }}">
        ← Back to Personal Information
    </a>

</div>

@endsection
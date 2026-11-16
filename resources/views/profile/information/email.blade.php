@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Change Email</h1>


    {{-- ==================================================
         CURRENT EMAIL
         ================================================== --}}

    <p>
        <strong>Current Email:</strong>
        {{ $currentUser->email }}
    </p>


    {{-- ==================================================
         CHANGE EMAIL FORM
         ================================================== --}}

    <form action="{{ route('profile.information.email.update') }}" method="POST">

        @csrf

        {{-- Laravel trasforma la richiesta POST in PATCH --}}
        @method('PATCH')

        <label for="email" class="form-label">
            New Email
        </label>

        {{-- 'is-invalid' colora il campo di rosso se c'è un errore di validazione --}}
        <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $currentUser->email) }}"
            required
        >

        {{-- Messaggio di errore sotto il campo (es. email già usata) --}}
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <button type="submit">
            Update Email
        </button>

    </form>


    {{-- Torna alla pagina delle informazioni personali --}}
    <a href="{{ route('profile.information') }}">
        ← Back to Personal Information
    </a>

</div>

@endsection
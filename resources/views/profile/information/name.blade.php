@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Change Name</h1>


    {{-- ==================================================
         CHANGE NAME FORM
         ================================================== --}}

    <form action="{{ route('profile.information.name.update') }}" method="POST">

        @csrf

        {{-- Laravel trasforma la richiesta POST in PATCH --}}
        @method('PATCH')

        <label for="name" class="form-label">
            New Name
        </label>

        {{-- 'is-invalid' colora il campo di rosso se c'è un errore di validazione --}}
        <input
            type="text"
            id="name"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $currentUser->name) }}"
            required
        >

        {{-- Messaggio di errore sotto il campo (es. nome troppo lungo) --}}
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <button type="submit">
            Update Name
        </button>

    </form>


    {{-- Torna alla pagina delle informazioni personali --}}
    <a href="{{ route('profile.information') }}">
        ← Back to Personal Information
    </a>

</div>

@endsection
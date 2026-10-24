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

        <label for="email">
            New Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ $currentUser->email }}"
            required
        >

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
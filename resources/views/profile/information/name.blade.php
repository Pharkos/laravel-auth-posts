@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Change Name</h1>


    {{-- ==================================================
         CHANGE NAME FORM
         ================================================== --}}

    <form action="{{ route('profile.information.name.update') }}" method="POST">

        @csrf

        <label for="name">
            New Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ $currentUser->name }}"
            required
        >

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

@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Change Password</h1>


    {{-- ==================================================
         CHANGE PASSWORD FORM
         ================================================== --}}

    <form action="{{ route('profile.information.password.update') }}" method="POST">

        @csrf

        <label for="current_password">
            Current Password
        </label>

        <input
            type="password"
            id="current_password"
            name="current_password"
            required
        >

        <br><br>

        <label for="password">
            New Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <label for="password_confirmation">
            Confirm New Password
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
        >

        <br><br>

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
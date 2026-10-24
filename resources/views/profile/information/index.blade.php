
@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Personal Information</h1>


    {{-- ==================================================
         USER INFORMATION
         ================================================== --}}

    <h2>Account Information</h2>

    <p>
        <strong>Name:</strong>
        {{ $currentUser->name }}

        <a href="{{ route('profile.information.name') }}">
            Change Name
        </a>
    </p>

    <p>
        <strong>Email:</strong>
        {{ $currentUser->email }}

        <a href="{{ route('profile.information.email') }}">
            Change Email
        </a>
    </p>

    <p>
        <strong>Password:</strong>
        ********

        <a href="{{ route('profile.information.password') }}">
            Change Password
        </a>
    </p>

</div>

@endsection


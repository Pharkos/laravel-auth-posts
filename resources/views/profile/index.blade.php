
@extends('layouts.app')

@section('content')

<div class="container">

    <h1>My Profile</h1>


    {{-- ==================================================
         PROFILE SECTIONS

         In futuro il menu "My Profile" della navigazione
         principale conterrà:
         - Dashboard
         - My Posts
         - Personal Information

         Personal Information:
         - Modifica nome
         - Modifica email
         - Modifica password
         ================================================== --}}


    {{-- ==================================================
         DASHBOARD CONTENT
         ================================================== --}}

    <h2>Dashboard</h2>

    <p>
        Benvenuto, {{ $currentUser->name }}!
    </p>

</div>

@endsection


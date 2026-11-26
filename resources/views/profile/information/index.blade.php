@extends('layouts.app')

@section('content')

<div class="col-lg-8 mx-auto">

    <h1 class="h3 mb-4">Dati personali</h1>

    <div class="card shadow-sm">

        {{-- list-group-flush: righe senza bordi esterni, dentro la card --}}
        <ul class="list-group list-group-flush">

            {{-- Nome --}}
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div>
                    <div class="small text-muted">Nome</div>
                    <div class="fw-semibold">{{ $currentUser->name }}</div>
                </div>
                <a href="{{ route('profile.information.name') }}" class="btn btn-outline-primary btn-sm">
                    Modifica
                </a>
            </li>

            {{-- Email --}}
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div>
                    <div class="small text-muted">Email</div>
                    <div class="fw-semibold">{{ $currentUser->email }}</div>
                </div>
                <a href="{{ route('profile.information.email') }}" class="btn btn-outline-primary btn-sm">
                    Modifica
                </a>
            </li>

            {{-- Password: non mostriamo mai il valore reale --}}
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div>
                    <div class="small text-muted">Password</div>
                    <div class="fw-semibold">••••••••</div>
                </div>
                <a href="{{ route('profile.information.password') }}" class="btn btn-outline-primary btn-sm">
                    Modifica
                </a>
            </li>

        </ul>
    </div>

</div>

@endsection
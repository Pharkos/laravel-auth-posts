{{-- ==================================================
     MESSAGGI FLASH
     Mostra i messaggi salvati in sessione con ->with('success', '...')
     come alert di Bootstrap, chiudibili con la X
     ================================================== --}}
@php
    // Chiave in sessione => classe colore di Bootstrap
    $alertTypes = [
        'success' => 'success',
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
    ];
@endphp

@foreach ($alertTypes as $key => $color)
    @if (session($key))
        <div class="alert alert-{{ $color }} alert-dismissible fade show" role="alert">
            {{ session($key) }}

            {{-- data-bs-dismiss="alert": il JavaScript di Bootstrap chiude l'alert --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    @endif
@endforeach
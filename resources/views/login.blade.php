{{-- estende la pagina app  --}}
@extends('layouts.app')

@section('content')

<h2>Login del cliente</h2>

<div>
        @if($errors->any() )
            @foreach ($errors->all() as $error )
                <p style="color:red">{{ $error }}</p>         
            @endforeach
        @endif
</div>

{{-- route chiama la rotta nominata ->name('validateForm') --}}
<form action="{{ route('loginUser') }}" method="POST">
    {{-- evita attacchi cross site request forgery richiesta di falsificazione tra siti
          sfrutta il vostro log per catturare la sessione avviata.
          per evitare un attacco viene attivato un token di propietà Laravel e cosi faccendo 
          per evita che altre persone possono intrometersi. --}}
    @csrf 

    {{--old() se viene sbagliato un campo, laravel mantiene in memoria l'ultimo valore assegnato  --}}

    email <input type="email" name="email" id="email" value="{{old('email')}}"><br>
   
    password <input type="password" name="password" id="password" > <br>

    <input type="submit" value="Invia">

</form>

@endsection

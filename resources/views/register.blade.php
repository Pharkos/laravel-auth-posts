
@extends ('layouts.app')

@section('content')

<h2>Form per la creazione del cliente</h2>
<div>
    <ul>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        @endif
    </ul>
</div>

{{-- route chiama la rotta nominata ->name('register') --}}
<form action="{{ route('register') }}" method="POST">
    {{-- evita attacchi cross site request forgery richiesta di falsificazione tra siti
          sfrutta il vostro log per catturare la sessione avviata.
          per evitare un attacco viene attivato un token di propietà Laravel e cosi faccendo 
          per evita che altre persone possono intrometersi. --}}
    @csrf 

    {{--old() se viene sbagliato un campo, laravel mantiene in memoria l'ultimo valore assegnato  --}}
    nome <input type="text" name="name" id="name" value="{{ old('name')}}"><br>
    email <input type="email" name="email" id="email" value="{{ old('email')}}"><br>
    password <input type="password" name="password" id="password" > <br>
    {{-- name="password_confirmation" ATTENZIONE PER VALIDARE IL CAMPO DELLE DUE 
         password DEVI USARE IL NAME IMPOSTATO CON password_confirmation --}}
    Conferma password <input type="password" name="password_confirmation" id="password_confirmation"><br>

    <input type="submit" value="Invia">

</form>




@endsection


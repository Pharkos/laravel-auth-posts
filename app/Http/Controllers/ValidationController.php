<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ValidationController extends Controller
{
    public function showRegisterForm(){
        return view('register',['pageTitle' => 'Register',
   'metaTitle' => 'la mia pagina Register']);
    }

    public function validateForm(Request $request){

        $validateData = $request->validate(
            [
            'name' => 'required|string|max:255',  
            // unique:user,email: dice che non possono stare utenti con la stessa email
            // quindi users indica il nome della tabella e email il nome del campo  
            'email' => 'required|email|max:255|unique:users,email', 
            'password' => 'required|string|min:8|confirmed',
            ]
            );
        
        // crea l'user in base al modello, inserisci solo i campi che sono riportati
        // nel modello user 

        $user = User::create([
            'name' => $validateData['name'],    
            'email' => $validateData['email'],
            // la password viene hashata
            'password' => Hash::make($validateData['password'],),
        ]);

        // authentication fa il login in automatico 
        Auth::login($user);

        // verrai madato alla pagina che decidi noi abbiamo messo home
        // with crea la chiave success che stamperà il messaggio impostato 
        return redirect()->route('home')->with('success','Registrazione avvenuta con successo. Login effettuato');

        

    }



    // ----------- Sezione Login -----------

   // ----------- metodo get
    public function showLoginForm()  {
        return view('login',['pageTitle' => 'Login',
   'metaTitle' => 'la mia pagina Login']);
        
    }


  // Login: verifica le credenziali e autentica l'utente
public function login(Request $request)
{
    // Valida solo il formato dei dati (non controlla il database):
    // niente 'exists' per non rivelare quali email sono registrate
    $credentials = $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string',
    ]);

    // Cerca l'utente tramite email e confronta la password con l'hash salvato
    if (Auth::attempt($credentials)) {
        // Nuovo Session ID dopo il login (protezione da session fixation)
        $request->session()->regenerate();

        // Torna alla pagina richiesta prima del login, altrimenti alla home
        return redirect()->intended('/')->with('success', 'Login effettuato con successo');
    }

    // Credenziali errate: stesso messaggio generico in ogni caso,
    // l'errore va in $errors e l'email resta compilata nel form
    return back()
        ->withErrors(['email' => 'Credenziali non valide.'])
        ->onlyInput('email');
}

    
     // Logout: termina la sessione dell'utente in modo sicuro
                public function logout(Request $request)
                {
                    // Rimuove l'utente autenticato dalla sessione corrente
                    Auth::logout();

                    // Cancella tutti i dati della sessione e genera un nuovo Session ID
                    // (impedisce il riutilizzo della vecchia sessione)
                    $request->session()->invalidate();

                    // Genera un nuovo token CSRF: i form aperti con il vecchio token non sono più validi
                    $request->session()->regenerateToken();

                    return redirect('/')->with('success', 'Logout eseguito con successo');
                }



}



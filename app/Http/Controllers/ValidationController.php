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
            'age' => 'required|integer|min:18|max:108',
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


        public function login(Request $request){
        // Valida le credenziali di login.
        // 'email' deve essere un'email valida, non più lunga di 255 caratteri e unica nella tabella 'users'.
        // 'password' è obbligatoria e di almeno 8 caratteri.
        $credentials = $request->validate([
            'email' => 'required|email|max:255|exists:users,email', // Nota: 
            //deve essere solo 'exists:users,email' o semplicemente 'email'.
                                                                    // 'unique' è per la registrazione, non per il login.
            'password' => 'required|string|min:8',
        ]);

        // Tenta di autenticare l'utente con le credenziali fornite.
        // Auth::attempt() verifica se le credenziali corrispondono a un utente nel database
        // e se la password hashata corrisponde.
        if(Auth::attempt($credentials)){
            // Se l'autenticazione ha successo:
            // Rigenera l'ID della sessione per prevenire attacchi di fissazione della sessione.
            $request->session()->regenerate();
            // Reindirizza l'utente alla pagina che intendeva visitare prima del login,
            // o alla homepage ('/') se non c'era una pagina specifica.
            // ->with('success', '...') aggiunge un messaggio flash alla sessione.
            return redirect()->intended('/')->with('success', 'login effettuato con successo');
        }

        // Se l'autenticazione fallisce:
        // Reindirizza l'utente alla pagina precedente (tipicamente il form di login)
        // con un errore per l'email.
        // return back()->withErrors([
        //     'email' => 'Le credenziali fornite non corrispondono ai nostri record.',
        // ]);
        // O semplicemente reindirizza con un messaggio generico di errore.
        return back()->with('error', 'Credenziali non valide. Riprova.');
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



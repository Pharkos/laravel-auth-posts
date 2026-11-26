<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================================================
    // REGISTRAZIONE
    // ==========================================================

    // Mostra il form di registrazione
    public function showRegisterForm()
    {
        return view('register', [
            'pageTitle' => 'Registrati',
            'metaDescription' => 'Pagina di registrazione',
        ]);
    }

    // Registrazione: valida i dati, crea l'utente ed effettua il login automatico
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // unique:users,email → non possono esistere due utenti con la stessa email
            'email' => 'required|email|max:255|unique:users,email',
            // confirmed → deve coincidere con il campo 'password_confirmation'
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            // Non serve Hash::make(): nel model User il campo 'password'
            // ha il cast 'hashed', quindi Laravel genera l'hash prima del salvataggio
            'password' => $validatedData['password'],
        ]);

        // Login automatico: l'utente appena registrato non deve rifare il login
        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Registrazione avvenuta con successo. Login effettuato');
    }

    // ==========================================================
    // LOGIN & LOGOUT
    // ==========================================================

    // Mostra il form di login
    public function showLoginForm()
    {
        return view('login', [
            'pageTitle' => 'Accedi',
            'metaDescription' => 'Pagina di login',
        ]);
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

        // Chiave del limitatore: email + IP (es. "mario@test.com|127.0.0.1")
        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        // Troppi tentativi falliti: blocca prima ancora di controllare la password
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withErrors(['email' => "Troppi tentativi. Riprova tra {$seconds} secondi."])
                ->onlyInput('email');
        }

        // Cerca l'utente tramite email e confronta la password con l'hash salvato
        if (Auth::attempt($credentials)) {
            // Login riuscito: azzera il contatore dei tentativi
            RateLimiter::clear($throttleKey);

            // Nuovo Session ID dopo il login (protezione da session fixation)
            $request->session()->regenerate();

            // Torna alla pagina richiesta prima del login, altrimenti alla home
            return redirect()->intended('/')->with('success', 'Login effettuato con successo');
        }

        // Login fallito: +1 tentativo (il contatore scade dopo 60 secondi)
        RateLimiter::hit($throttleKey, 60);

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
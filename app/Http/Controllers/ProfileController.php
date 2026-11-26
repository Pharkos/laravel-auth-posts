<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
       // Mostra la dashboard del profilo dell'utente autenticato
    public function index()
    {
        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // count(): esegue un COUNT in SQL, senza caricare tutti i post in memoria
        $postsCount = $currentUser->posts()->count();

        // Gli ultimi 3 post dell'utente per la lista rapida
        $latestPosts = $currentUser->posts()->latest()->take(3)->get();

        return view('profile.index', [
            'pageTitle' => 'Il mio profilo',
            'metaTitle' => 'Dashboard del profilo',
            'currentUser' => $currentUser,
            'postsCount' => $postsCount,
            'latestPosts' => $latestPosts,
        ]);
    }

    // Mostra i post dell'utente autenticato
    public function myPosts()
    {
        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // posts() (con parentesi) restituisce una query: possiamo ordinare e paginare
        // prima di eseguirla. Solo i post dell'utente, i più recenti per primi, 9 per pagina

        // with('user'): la card mostra il nome dell'autore, lo carichiamo in una sola query (evita N+1)
        $posts = $currentUser->posts()->with('user')->latest()->paginate(9);

        return view('profile.posts', [
            'pageTitle' => 'My Posts',
            'metaTitle' => 'I miei post',
            'posts' => $posts,
        ]);

    }

    // Mostra le informazioni personali dell'utente autenticato
    public function information()
    {
        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // Restituisce la view delle informazioni personali
        return view('profile.information.index', [
            'pageTitle' => 'Personal Information',
            'metaTitle' => 'Informazioni personali',
            'currentUser' => $currentUser,
        ]);
    }

    // Mostra il form per modificare il nome
    public function editName()
    {
        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // Restituisce la view per la modifica del nome
        return view('profile.information.name', [
            'pageTitle' => 'Change Name',
            'metaTitle' => 'Modifica del nome',
            'currentUser' => $currentUser,
        ]);
    }

    // Aggiorna il nome dell'utente autenticato
    public function updateName(Request $request)
    {
        // Valida il nuovo nome ricevuto dal form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // Aggiorna il nome dell'utente nel database
        $currentUser->update([
            'name' => $validatedData['name'],
        ]);

        // Torna alla pagina delle informazioni personali
        return redirect()
            ->route('profile.information')
            ->with('success', 'Nome aggiornato con successo');
    }

    // Mostra il form per modificare l'email
    public function editEmail()
    {
        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // Restituisce la view per la modifica dell'email
        return view('profile.information.email', [
            'pageTitle' => 'Change Email',
            'metaTitle' => 'Modifica dell\'email',
            'currentUser' => $currentUser,
        ]);
    }

    // Aggiorna l'email dell'utente autenticato
    public function updateEmail(Request $request)
    {
        // Recupera l'utente attualmente autenticato
        $currentUser = auth()->user();

        // Valida la nuova email ricevuta dal form
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($currentUser->id),
            ],
        ]);

        // Aggiorna l'email dell'utente nel database
        $currentUser->update([
            'email' => $validatedData['email'],
        ]);

        // Torna alla pagina delle informazioni personali
        return redirect()
            ->route('profile.information')
            ->with('success', 'Email aggiornata con successo');
    }

    // Mostra il form per modificare la password
    public function editPassword()
    {
        // Restituisce la view per la modifica della password
        return view('profile.information.password', [
            'pageTitle' => 'Change Password',
            'metaTitle' => 'Modifica della password',
        ]);
    }

    // Aggiorna la password dell'utente autenticato
    public function updatePassword(Request $request)
    {
        // 'current_password': Laravel confronta la password inserita con quella
        // dell'utente loggato (fa Hash::check internamente).
        // Se è sbagliata, l'errore va in $errors e appare sotto il campo.
        $validatedData = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ], [
            // Messaggio personalizzato: più chiaro di quello di default
            'current_password.current_password' => 'La password attuale non è corretta.',
        ]);
        // Non serve Hash::make(): nel model User il campo 'password'
        // ha il cast 'hashed', quindi Laravel genera l'hash prima del salvataggio
        auth()->user()->update([
            'password' => $validatedData['password'],
        ]);

        return redirect()
            ->route('profile.information')
            ->with('success', 'Password aggiornata con successo');
    }
}

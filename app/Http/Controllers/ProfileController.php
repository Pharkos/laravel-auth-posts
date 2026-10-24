<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    // Mostra la pagina principale del profilo dell'utente autenticato
    public function index()
    {
       

         // Recupera l'utente attualmente autenticato
    $currentUser = auth()->user();

    // Restituisce la view principale del profilo
      return view('profile.index' , 
        ['pageTitle' => 'My Profile',
         'metaTitle' => 'Pagina principale del profilo',
         'currentUser' => $currentUser,]);
    }


    // Mostra i post dell'utente autenticato
public function myPosts()
{
    // Recupera l'utente attualmente autenticato
    $currentUser = auth()->user();

    // Recupera solo i post appartenenti all'utente
    $posts = $currentUser->posts;

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
    // Valida i dati ricevuti dal form
    $validatedData = $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);


    // Recupera l'utente attualmente autenticato
    $currentUser = auth()->user();

// Controlla che la password attuale sia corretta
    if (!Hash::check($validatedData['current_password'], $currentUser->password)) {

        return back()->with('error', 'La password attuale non è corretta.');
    }

  
// Aggiorna la password nel database
// Non utilizziamo Hash::make() perché nel modello User
// il campo "password" ha già il cast "hashed".
// Laravel esegue automaticamente l'hashing prima di salvare
// la nuova password nel database.
$currentUser->update([
    'password' => $validatedData['password'],
]);

// Torna alla pagina delle informazioni personali
return redirect()
    ->route('profile.information')
    ->with('success', 'Password aggiornata con successo');



}




}
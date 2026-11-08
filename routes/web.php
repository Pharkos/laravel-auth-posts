<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;


// ==========================================================
// HOME & ABOUT
// ==========================================================

// GET / → mostra la pagina Home
Route::get('/', function () {
    return view('home', [
        'pageTitle' => 'Homepage',
        'metaTitle' => 'la mia pagina Home',
    ]);
})->name('home');


// GET /about → mostra la pagina About
Route::get('/about', function () {
    return view('about', [
        'pageTitle' => 'About',
        'metaTitle' => 'la mia pagina About',
    ]);
})->name('about');


// ==========================================================
// AUTHENTICATION
// REGISTER, LOGIN & LOGOUT
// ==========================================================


// ---------- Guest Routes ----------
// Accessibili solo agli utenti NON autenticati.
// Se un utente già loggato prova ad aprirle,
// il middleware 'guest' lo reindirizza alla home.

Route::middleware('guest')->group(function () {

    // GET /register → mostra il form di registrazione
    Route::get('/register', [ValidationController::class, 'showRegisterForm'])
        ->name('register');

    // POST /validateForm → valida i dati e crea un nuovo User
    Route::post('/validateForm', [ValidationController::class, 'validateForm'])
        ->name('validateForm');

    // GET /login → mostra il form di Login
    Route::get('/login', [ValidationController::class, 'showLoginForm'])
        ->name('login');

    // POST /login → verifica le credenziali ed effettua il Login
    Route::post('/login', [ValidationController::class, 'login'])
        ->name('loginUser');
});


// ---------- Logout ----------
// Solo un utente autenticato può effettuare il logout:
// il middleware 'auth' blocca le richieste dei visitatori.

// POST /logout → effettua il Logout dell'utente
Route::post('/logout', [ValidationController::class, 'logout'])
    ->middleware('auth')
    ->name('logoutUser');


// ==========================================================
// POSTS
// ==========================================================


// ---------- Public Routes ----------
// Accessibili anche agli utenti non autenticati


// GET /posts → visualizza la lista dei post
Route::get('/posts', [PostController::class, 'index'])
    ->name('post.index');


// ---------- Protected Routes ----------
// Accessibili solo agli utenti autenticati

Route::middleware('auth')->group(function () {

    // GET /posts/create → mostra il form per creare un post
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('post.create');

    // POST /posts → valida e salva un nuovo post
    Route::post('/posts', [PostController::class, 'store'])
        ->name('post.store');

    // GET /posts/{id}/edit → mostra il form per modificare un post
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
        ->name('post.edit');

    // PUT /posts/{id} → aggiorna un post
    Route::put('/posts/{id}', [PostController::class, 'update'])
        ->name('post.update');

    // DELETE /posts/{id} → elimina un post
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])
        ->name('post.destroy');
});


// GET /posts/{id} → visualizza un singolo post
Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('post.show');



    // ==========================================================
// PROFILE
// ==========================================================

Route::middleware('auth')->group(function () {

    // GET /profile → mostra la pagina principale del profilo
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    // GET /profile/posts → mostra i post dell'utente autenticato
    Route::get('/profile/posts', [ProfileController::class, 'myPosts'])
    ->name('profile.posts');

    // GET /profile/information → mostra le informazioni personali
    Route::get('/profile/information', [ProfileController::class, 'information'])
    ->name('profile.information');

        // GET /profile/information/name → mostra il form per modificare il nome
    Route::get('/profile/information/name', [ProfileController::class, 'editName'])
        ->name('profile.information.name');

            // POST /profile/information/name → aggiorna il nome dell'utente
    Route::post('/profile/information/name', [ProfileController::class, 'updateName'])
        ->name('profile.information.name.update');

        // GET /profile/information/email → mostra il form per modificare l'email
    Route::get('/profile/information/email', [ProfileController::class, 'editEmail'])
    ->name('profile.information.email');


    // POST /profile/information/email → aggiorna l'email dell'utente
Route::post('/profile/information/email', [ProfileController::class, 'updateEmail'])
    ->name('profile.information.email.update');

    // GET /profile/information/password → mostra il form per modificare la password
Route::get('/profile/information/password', [ProfileController::class, 'editPassword'])
    ->name('profile.information.password');


    // POST /profile/information/password → aggiorna la password dell'utente
Route::post('/profile/information/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.information.password.update');

});
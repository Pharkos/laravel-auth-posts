<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

        // POST /register → valida i dati, crea un nuovo User ed effettua il login
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    // GET /login → mostra il form di Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    // POST /login → verifica le credenziali ed effettua il Login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('loginUser');
});


// ---------- Logout ----------
// Solo un utente autenticato può effettuare il logout:
// il middleware 'auth' blocca le richieste dei visitatori.

// POST /logout → effettua il Logout dell'utente
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logoutUser');


// ==========================================================
// POSTS
// ==========================================================

// Route::resource crea le 7 rotte CRUD standard (posts.index, posts.show, ecc.)

// ---------- Protected Routes ----------
// create, store, edit, update, destroy: solo utenti autenticati.
// Devono stare PRIMA di 'show', altrimenti /posts/create
// verrebbe interpretato come /posts/{post} con post = "create" (404)
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)
        ->except(['index', 'show']);
});

// ---------- Public Routes ----------
// index e show: accessibili anche ai visitatori
Route::resource('posts', PostController::class)
    ->only(['index', 'show']);





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

        // PATCH /profile/information/name → aggiorna il nome dell'utente
    Route::patch('/profile/information/name', [ProfileController::class, 'updateName'])
        ->name('profile.information.name.update');

        // GET /profile/information/email → mostra il form per modificare l'email
    Route::get('/profile/information/email', [ProfileController::class, 'editEmail'])
    ->name('profile.information.email');


       // PATCH /profile/information/email → aggiorna l'email dell'utente
    Route::patch('/profile/information/email', [ProfileController::class, 'updateEmail'])
    ->name('profile.information.email.update');

    // GET /profile/information/password → mostra il form per modificare la password
Route::get('/profile/information/password', [ProfileController::class, 'editPassword'])
    ->name('profile.information.password');


        // PATCH /profile/information/password → aggiorna la password dell'utente
    Route::patch('/profile/information/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.information.password.update');

});

# Laravel Auth & Posts

**A Laravel 12 web application with user authentication, post management (CRUD) and ownership-based authorization.**

[English](#english) · [Italiano](#italiano)

---

<a id="english"></a>

## 🇬🇧 English

### About

A personal learning project, built step by step to understand how a Laravel application works end to end — from routing and controllers to Eloquent models, authentication and authorization.

**Status:** in progress. The core features work; code quality, tests and UI are being improved incrementally (see [Roadmap](#roadmap)).

### Features

- **Authentication** — registration, login and logout (session-based).
- **Posts CRUD** — create, read, update and delete posts.
- **Ownership rules** — only the author can edit or delete their own post.
- **Public and protected pages** — anyone can browse posts; creating and managing them requires login (`auth` middleware).
- **User profile** — dashboard, list of the user's own posts, change name, email and password.
- **Server-side validation** and **flash messages** for success and error feedback.
- **Blade layout** with reusable partials, styled with Bootstrap 5.

### Key Technical Decisions

- **Authorization is enforced on the server, not only in the UI.**
  `PostPolicy` checks that the logged-in user owns the post. The controller calls `Gate::authorize()` before edit, update and delete, and Blade uses `@can` to show the buttons only to the author. Hiding a button alone would not protect the route.

- **Session regeneration after login.**
  After a successful login, `$request->session()->regenerate()` issues a new session ID to protect against session fixation.

- **Safe account updates.**
  Changing the password requires the current password (`Hash::check()`). Changing the email uses `Rule::unique()->ignore()`, so duplicates are blocked while the user can keep their own address.

- **Data integrity at database level.**
  `posts.user_id` is a foreign key with cascade delete, so a post can never reference a user that no longer exists.

- **Eloquent relationships.**
  `User hasMany Post` and `Post belongsTo User` are used to show each post's author and the user's own posts (`$user->posts`).

### Tech Stack

| Technology | Purpose |
|---|---|
| PHP 8.2 · Laravel 12 | Backend and application framework |
| Eloquent ORM | Models and relationships |
| MariaDB / MySQL | Relational database |
| Blade | Server-rendered views |
| Bootstrap 5 · CSS | Layout and styling |
| Vite | Frontend asset build |
| Git · GitHub | Version control |

<a id="roadmap"></a>

### Roadmap

- [ ] Move validation into Form Request classes
- [ ] Show validation errors and keep old input in all forms
- [ ] Rename `ValidationController` to `AuthController` and make route names consistent
- [ ] Add `guest` middleware to the login and registration routes
- [ ] Use Route Model Binding instead of manual `findOrFail()`
- [ ] Harden authentication: generic login error message, CSRF token regeneration on logout
- [ ] Add pagination to the post list
- [ ] Add feature tests for authentication and post ownership
- [ ] Deploy a live demo

### Getting Started

**Requirements:** PHP 8.2+, Composer, Node.js and npm, MariaDB or MySQL, Git.

```bash
git clone https://github.com/Pharkos/laravel-auth-posts.git
cd laravel-auth-posts

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create a database, set the connection in `.env`, then:

```bash
php artisan migrate
npm run dev          # terminal 1
php artisan serve    # terminal 2
```

Open `http://127.0.0.1:8000`.

### Development Approach

I build features incrementally and focus on understanding **why** a solution works before moving on. AI tools support my learning — explanations, debugging and code review — with the goal of being able to explain every part of the code independently.

### Author

**Vakhtang Pharkosadze** · GitHub: [@Pharkos](https://github.com/Pharkos)

---

<a id="italiano"></a>

## 🇮🇹 Italiano

### Descrizione

Progetto personale di apprendimento, sviluppato passo dopo passo per capire come funziona un'applicazione Laravel nel suo insieme: dal routing e dai controller ai model Eloquent, fino all'autenticazione e all'autorizzazione.

**Stato:** in sviluppo. Le funzionalità principali sono operative; qualità del codice, test e interfaccia vengono migliorati progressivamente (vedi [Roadmap](#roadmap-it)).

### Funzionalità

- **Autenticazione** — registrazione, login e logout (basati su sessione).
- **CRUD dei post** — creazione, visualizzazione, modifica ed eliminazione.
- **Regole di proprietà** — solo l'autore può modificare o eliminare i propri post.
- **Pagine pubbliche e protette** — chiunque può consultare i post; per crearli e gestirli è necessario il login (middleware `auth`).
- **Profilo utente** — dashboard, elenco dei propri post, modifica di nome, email e password.
- **Validazione lato server** e **messaggi flash** di conferma ed errore.
- **Layout Blade** con partial riutilizzabili e stile Bootstrap 5.

### Scelte tecniche principali

- **L'autorizzazione è verificata sul server, non solo nell'interfaccia.**
  `PostPolicy` controlla che l'utente autenticato sia il proprietario del post. Il controller chiama `Gate::authorize()` prima di modifica, aggiornamento ed eliminazione, mentre Blade usa `@can` per mostrare i pulsanti solo all'autore. Nascondere un pulsante non basterebbe a proteggere la route.

- **Rigenerazione della sessione dopo il login.**
  Dopo un login riuscito, `$request->session()->regenerate()` genera un nuovo ID di sessione per proteggere da attacchi di session fixation.

- **Aggiornamento sicuro dell'account.**
  Per cambiare la password è richiesta quella attuale (`Hash::check()`). Per cambiare l'email si usa `Rule::unique()->ignore()`: i duplicati vengono bloccati, ma l'utente può mantenere il proprio indirizzo.

- **Integrità dei dati a livello di database.**
  `posts.user_id` è una foreign key con eliminazione a cascata: un post non può mai fare riferimento a un utente inesistente.

- **Relazioni Eloquent.**
  `User hasMany Post` e `Post belongsTo User` servono a mostrare l'autore di ogni post e i post dell'utente (`$user->posts`).

### Tecnologie

| Tecnologia | Utilizzo |
|---|---|
| PHP 8.2 · Laravel 12 | Backend e framework applicativo |
| Eloquent ORM | Model e relazioni |
| MariaDB / MySQL | Database relazionale |
| Blade | View renderizzate lato server |
| Bootstrap 5 · CSS | Layout e stile |
| Vite | Build degli asset frontend |
| Git · GitHub | Controllo di versione |

<a id="roadmap-it"></a>

### Roadmap

- [ ] Spostare la validazione in classi Form Request
- [ ] Mostrare gli errori di validazione e mantenere i valori inseriti in tutti i form
- [ ] Rinominare `ValidationController` in `AuthController` e uniformare i nomi delle route
- [ ] Aggiungere il middleware `guest` alle route di login e registrazione
- [ ] Usare il Route Model Binding al posto di `findOrFail()` manuale
- [ ] Rafforzare l'autenticazione: messaggio di errore generico al login, rigenerazione del token CSRF al logout
- [ ] Aggiungere la paginazione all'elenco dei post
- [ ] Aggiungere feature test per autenticazione e proprietà dei post
- [ ] Pubblicare una demo online

### Installazione

**Requisiti:** PHP 8.2+, Composer, Node.js e npm, MariaDB o MySQL, Git.

```bash
git clone https://github.com/Pharkos/laravel-auth-posts.git
cd laravel-auth-posts

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Creare un database, configurare la connessione nel file `.env`, quindi:

```bash
php artisan migrate
npm run dev          # terminale 1
php artisan serve    # terminale 2
```

Aprire `http://127.0.0.1:8000`.

### Approccio allo sviluppo

Sviluppo le funzionalità in modo incrementale, concentrandomi sul capire **perché** una soluzione funziona prima di andare avanti. Gli strumenti di AI supportano il mio apprendimento — spiegazioni, debugging e revisione del codice — con l'obiettivo di saper spiegare autonomamente ogni parte del codice.

### Autore

**Vakhtang Pharkosadze** · GitHub: [@Pharkos](https://github.com/Pharkos)

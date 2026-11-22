<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // migrate:fresh svuota il database ma non i file: cancelliamo le vecchie immagini
        // dei post, così non restano file orfani
        Storage::disk('public')->deleteDirectory('posts');

        // Utente demo con credenziali note (password "password", definita nella UserFactory)
        $demo = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
        ]);

        // Altri utenti con nomi italiani (APP_FAKER_LOCALE=it_IT), senza l'utente demo
        $otherUsers = User::factory(3)->create();

        // Post senza immagine (più vecchi): mostrano il placeholder e attivano la paginazione
        Post::factory(6)
            ->state(fn () => [
                'user_id' => $otherUsers->random()->id,
                'created_at' => now()->subDays(rand(10, 30)),
            ])
            ->create();

        // Post "vetrina" con immagine e testo reale (più recenti, quindi in prima pagina)
        $posts = [
            [
                'title' => 'Come funziona una richiesta in Laravel',
                'content' => "Quando un utente apre una pagina, la richiesta passa dalla rotta al middleware, poi al controller.\n\nIl controller usa il model per leggere i dati dal database e restituisce una view Blade con l'HTML finale.",
            ],
            [
                'title' => 'Autenticazione e autorizzazione',
                'content' => "L'autenticazione verifica chi sei: è il compito del middleware 'auth'.\n\nL'autorizzazione verifica cosa puoi fare: in questo progetto una Policy controlla che solo l'autore possa modificare o eliminare un post.",
            ],
            [
                'title' => 'Perché scrivere test automatici',
                'content' => "I test controllano in pochi secondi login, permessi e validazione.\n\nQuando modifico il codice, li eseguo con 'php artisan test' e so subito se ho rotto qualcosa.",
            ],
            [
                'title' => 'Caricare immagini con Laravel Storage',
                'content' => "Le immagini vengono salvate sul disco 'public' e nel database resta solo il percorso.\n\nQuando un post viene modificato o eliminato, anche il file vecchio viene cancellato: niente file orfani.",
            ],
            [
                'title' => 'Git: branch e pull request',
                'content' => "Ogni modifica nasce su un branch separato, con commit piccoli e descrittivi.\n\nPoi apro una pull request su GitHub, la controllo e faccio il merge nel branch main.",
            ],
            [
                'title' => 'Proteggere il login dagli attacchi brute force',
                'content' => "Dopo 5 tentativi falliti per la stessa email e lo stesso IP, il login viene bloccato per un minuto.\n\nIn più il messaggio di errore è sempre lo stesso, così non si può scoprire quali email sono registrate.",
            ],
        ];

        foreach ($posts as $index => $data) {
            // Copia l'immagine demo nel disco 'public', come se fosse stata caricata da un utente
            $imagePath = Storage::disk('public')->putFile(
                'posts',
                new File(database_path('seeders/images/post-'.($index + 1).'.jpg'))
            );

            Post::factory()->create([
                // Solo i primi due post sono dell'utente demo: così può provare modifica ed
                // eliminazione sui suoi post e vedere che sui post altrui i pulsanti non compaiono
                'user_id' => $index < 2 ? $demo->id : $otherUsers->random()->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => $imagePath,
                'created_at' => now()->subDays(count($posts) - $index),
            ]);
        }
    }
}
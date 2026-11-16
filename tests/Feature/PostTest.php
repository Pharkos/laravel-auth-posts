<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Nei test non serve compilare CSS/JS con Vite
        $this->withoutVite();
    }

    // ---------- Pagine pubbliche ----------

    // Chiunque (anche un visitatore) può vedere la lista dei post
    public function test_guest_can_view_posts_list(): void
    {
        $post = Post::factory()->create();

        $this->get('/posts')
            ->assertOk()
            ->assertSee($post->title);
    }

    // Chiunque può vedere un singolo post
    public function test_guest_can_view_a_single_post(): void
    {
        $post = Post::factory()->create();

        $this->get("/posts/{$post->id}")
            ->assertOk()
            ->assertSee($post->title);
    }

    // Route model binding: un post inesistente restituisce 404
    public function test_non_existent_post_returns_404(): void
    {
        $this->get('/posts/99999')->assertNotFound();
    }

    // ---------- Creazione ----------

    // Middleware 'auth': un visitatore non può aprire il form di creazione
    public function test_guest_cannot_access_create_form(): void
    {
        $this->get('/posts/create')->assertRedirect('/login');
    }

    // Un utente loggato può creare un post: viene salvato con il suo user_id
    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Il mio post',
            'content' => 'Contenuto di prova',
        ]);

        $response->assertRedirect('/posts');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('posts', [
            'title' => 'Il mio post',
            'user_id' => $user->id,
        ]);
    }

    // PostRequest: senza titolo il post non viene salvato
    public function test_post_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'title' => '',
            'content' => 'Contenuto di prova',
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('posts', 0);
    }

    // ---------- Modifica (PostPolicy::update) ----------

    // L'autore può modificare il proprio post
    public function test_author_can_update_own_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($post->user)->put("/posts/{$post->id}", [
            'title' => 'Titolo aggiornato',
            'content' => 'Contenuto aggiornato',
        ]);

        $response->assertRedirect("/posts/{$post->id}");
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Titolo aggiornato',
        ]);
    }

    // Un altro utente non può aprire il form di modifica: 403
    public function test_other_user_cannot_access_edit_form(): void
    {
        $post = Post::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->get("/posts/{$post->id}/edit")
            ->assertForbidden();
    }

    // Un altro utente non può modificare il post: 403 e il titolo resta uguale
    public function test_other_user_cannot_update_post(): void
    {
        $post = Post::factory()->create(['title' => 'Originale']);
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->put("/posts/{$post->id}", [
                'title' => 'Hackerato',
                'content' => 'Contenuto',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Originale',
        ]);
    }

    // ---------- Eliminazione (PostPolicy::delete) ----------

    // L'autore può eliminare il proprio post
    public function test_author_can_delete_own_post(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($post->user)
            ->delete("/posts/{$post->id}")
            ->assertRedirect('/posts');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    // Un altro utente non può eliminare il post: 403 e il post esiste ancora
    public function test_other_user_cannot_delete_post(): void
    {
        $post = Post::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->delete("/posts/{$post->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}

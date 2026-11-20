<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // Disco finto: i file dei test non finiscono nella cartella reale storage/app/public
        Storage::fake('public');
    }

    // ---------- Creazione ----------

    // L'immagine viene salvata sul disco e nel database resta solo il percorso
    public function test_user_can_create_post_with_image(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/posts', [
            'title' => 'Post con foto',
            'content' => 'Contenuto',
            'image' => UploadedFile::fake()->create('foto.jpg', 500, 'image/jpeg'),
        ])->assertRedirect('/posts');

        $post = Post::first();
        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);
    }

    // L'immagine è facoltativa
    public function test_post_can_be_created_without_image(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/posts', [
            'title' => 'Post senza foto',
            'content' => 'Contenuto',
        ])->assertRedirect('/posts');

        $this->assertNull(Post::first()->image);
    }

    // ---------- Validazione ----------

    // Un file che non è un'immagine (es. PDF) viene rifiutato
    public function test_non_image_file_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/posts', [
            'title' => 'Post',
            'content' => 'Contenuto',
            'image' => UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf'),
        ])->assertSessionHasErrors('image');

        $this->assertDatabaseCount('posts', 0);
    }

    // Un'immagine più grande di 2 MB viene rifiutata
    public function test_image_larger_than_2mb_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/posts', [
            'title' => 'Post',
            'content' => 'Contenuto',
            'image' => UploadedFile::fake()->create('grande.jpg', 3000, 'image/jpeg'),
        ])->assertSessionHasErrors('image');

        $this->assertDatabaseCount('posts', 0);
    }

    // ---------- Modifica ----------

    // Nuova immagine: viene salvata e la vecchia viene cancellata dal disco
    public function test_updating_image_replaces_and_deletes_old_file(): void
    {
        $oldPath = UploadedFile::fake()->create('vecchia.jpg', 100, 'image/jpeg')->store('posts', 'public');
        $post = Post::factory()->create(['image' => $oldPath]);

        $this->actingAs($post->user)->put("/posts/{$post->id}", [
            'title' => 'Titolo',
            'content' => 'Contenuto',
            'image' => UploadedFile::fake()->create('nuova.jpg', 100, 'image/jpeg'),
        ])->assertRedirect("/posts/{$post->id}");

        $post->refresh();
        $this->assertNotSame($oldPath, $post->image);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($post->image);
    }

    // Nessuna nuova immagine: quella vecchia resta
    public function test_update_without_new_image_keeps_old_one(): void
    {
        $oldPath = UploadedFile::fake()->create('vecchia.jpg', 100, 'image/jpeg')->store('posts', 'public');
        $post = Post::factory()->create(['image' => $oldPath]);

        $this->actingAs($post->user)->put("/posts/{$post->id}", [
            'title' => 'Titolo aggiornato',
            'content' => 'Contenuto',
        ]);

        $this->assertSame($oldPath, $post->fresh()->image);
        Storage::disk('public')->assertExists($oldPath);
    }

    // ---------- Eliminazione ----------

    // Eliminando il post viene cancellata anche la sua immagine
    public function test_deleting_post_deletes_its_image(): void
    {
        $path = UploadedFile::fake()->create('foto.jpg', 100, 'image/jpeg')->store('posts', 'public');
        $post = Post::factory()->create(['image' => $path]);

        $this->actingAs($post->user)->delete("/posts/{$post->id}");

        Storage::disk('public')->assertMissing($path);
    }
}

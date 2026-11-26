<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    // Crea le tabelle nel database di test prima di ogni test
    use RefreshDatabase;

    public function test_home_page_loads_without_posts(): void
    {
        // Senza post la Home deve comunque funzionare e mostrare il messaggio vuoto
        $this->get('/')
            ->assertOk()
            ->assertSee('Non ci sono ancora post.');
    }

    public function test_home_shows_only_the_three_latest_posts(): void
    {
        // Un post vecchio che NON deve comparire
        Post::factory()->create([
            'title' => 'Post più vecchio',
            'created_at' => now()->subDays(10),
        ]);

        // Tre post recenti che devono comparire
        $latestPosts = Post::factory()->count(3)->create();

        $response = $this->get('/')->assertOk();

        foreach ($latestPosts as $post) {
            $response->assertSee($post->title);
        }

        $response->assertDontSee('Post più vecchio');
    }
}
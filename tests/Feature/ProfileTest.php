<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Nei test non serve compilare CSS/JS con Vite
        $this->withoutVite();
    }

    // Middleware 'auth': un visitatore non può vedere il profilo
    public function test_guest_cannot_access_profile(): void
    {
        $this->get('/profile')->assertRedirect('/login');
    }

    // ---------- My Posts ----------

    // L'utente vede solo i propri post, non quelli degli altri
    public function test_user_sees_only_own_posts(): void
    {
        $user = User::factory()->create();

        $ownPost = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Il mio post',
        ]);

        $otherPost = Post::factory()->create([
            'title' => 'Post di un altro utente',
        ]);

        $this->actingAs($user)
            ->get('/profile/posts')
            ->assertOk()
            ->assertSee($ownPost->title)
            ->assertDontSee($otherPost->title);
    }

    // ---------- Nome ----------

    // L'utente può cambiare il proprio nome
    public function test_user_can_update_name(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profile/information/name', ['name' => 'Nuovo Nome'])
            ->assertRedirect('/profile/information')
            ->assertSessionHas('success');

        $this->assertSame('Nuovo Nome', $user->fresh()->name);
    }

    // Le rotte di aggiornamento accettano solo PATCH: POST restituisce 405
    public function test_profile_update_routes_do_not_accept_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/profile/information/name', ['name' => 'Nuovo Nome'])
            ->assertStatus(405);
    }

    // ---------- Email ----------

    // L'utente può cambiare la propria email
    public function test_user_can_update_email(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profile/information/email', ['email' => 'nuova@test.com'])
            ->assertRedirect('/profile/information');

        $this->assertSame('nuova@test.com', $user->fresh()->email);
    }

    // Non si può usare l'email di un altro utente (Rule::unique)
    public function test_user_cannot_use_email_of_another_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create(['email' => 'occupata@test.com']);

        $this->actingAs($user)
            ->patch('/profile/information/email', ['email' => 'occupata@test.com'])
            ->assertSessionHasErrors('email');

        $this->assertNotSame('occupata@test.com', $user->fresh()->email);
    }

    // Rule::unique()->ignore(): l'utente può salvare di nuovo la propria email
    public function test_user_can_keep_own_email(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profile/information/email', ['email' => $user->email])
            ->assertSessionHasNoErrors();
    }

    // ---------- Password ----------

    // Password attuale sbagliata: errore su current_password, password invariata
    public function test_wrong_current_password_is_rejected(): void
    {
        $user = User::factory()->create(); // password: 'password'

        $this->actingAs($user)
            ->patch('/profile/information/password', [
                'current_password' => 'sbagliata123',
                'password' => 'nuovapassword',
                'password_confirmation' => 'nuovapassword',
            ])
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    // Password attuale corretta: la nuova password viene salvata (come hash)
    public function test_user_can_update_password(): void
    {
        $user = User::factory()->create(); // password: 'password'

        $this->actingAs($user)
            ->patch('/profile/information/password', [
                'current_password' => 'password',
                'password' => 'nuovapassword',
                'password_confirmation' => 'nuovapassword',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile/information');

        $this->assertTrue(Hash::check('nuovapassword', $user->fresh()->password));
    }




        public function test_dashboard_counts_only_own_posts(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // 2 post dell'utente e 1 di un altro utente
        Post::factory()->count(2)->create(['user_id' => $user->id]);
        Post::factory()->create(['user_id' => $otherUser->id]);

        // assertViewHas: controlla il valore passato dal controller alla view
        $this->actingAs($user)
            ->get('/profile')
            ->assertOk()
            ->assertViewHas('postsCount', 2)
            ->assertViewHas('latestPosts', fn ($posts) => $posts->count() === 2);
    }
}

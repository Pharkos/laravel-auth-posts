<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // Ricrea un database vuoto prima di ogni test:
    // ogni test parte da zero e non dipende dagli altri
    use RefreshDatabase;

    // Login con credenziali corrette: l'utente viene autenticato
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    // Password errata: errore generico sul campo email, nessun login
    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'sbagliata',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // Email inesistente: stesso errore della password errata (no user enumeration)
    public function test_login_with_unknown_email_returns_same_generic_error(): void
    {
        $response = $this->post('/login', [
            'email' => 'nessuno@test.com',
            'password' => 'qualsiasi',
        ]);

        $response->assertSessionHasErrors(['email' => 'Credenziali non valide.']);
        $this->assertGuest();
    }

    // Middleware 'guest': un utente loggato non può aprire login e register
    public function test_authenticated_user_is_redirected_away_from_login_and_register(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/login')->assertRedirect(route('home'));
        $this->actingAs($user)->get('/register')->assertRedirect(route('home'));
    }

    // Logout: l'utente non è più autenticato
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    // Middleware 'auth': un visitatore non può fare logout, viene mandato al login
    public function test_guest_cannot_access_logout(): void
    {
        $this->post('/logout')->assertRedirect(route('login'));
    }

    // Registrazione: crea l'utente, effettua il login e salva la password come hash
    public function test_user_can_register_and_password_is_hashed(): void
    {
        $response = $this->post('/register', [
            'name' => 'Mario',
            'email' => 'mario@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'mario@test.com')->first();
        $this->assertNotNull($user);
        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
    }
}
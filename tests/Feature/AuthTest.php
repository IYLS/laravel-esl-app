<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function unauthenticated_user_can_view_the_landing_page()
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('auth.landing');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function authenticated_teacher_can_access_home()
    {
        $user = User::factory()->create([
            'role' => 'teacher',
            'email' => 'teacher@test.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function login_page_is_accessible()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function authenticated_user_is_redirected_from_login()
    {
        $user = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($user)->get('/login');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth.index'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_logout()
    {
        $user = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($user)->get('/logout');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth.index'));
        $this->assertGuest();
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth.login'));
    }

    /** @test */
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

    /** @test */
    public function login_page_is_accessible()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_is_redirected_from_login()
    {
        $user = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($user)->get('/login');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth.index'));
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($user)->get('/logout');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth.login'));
        $this->assertGuest();
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        // La ruta '/' redirige a login si no hay usuario autenticado
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth.login'));
    }

    /**
     * Test que la aplicación retorna respuesta exitosa cuando el usuario está autenticado
     *
     * @return void
     */
    public function test_authenticated_user_can_access_home()
    {
        $user = User::factory()->create(['role' => 'teacher']);
        
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}

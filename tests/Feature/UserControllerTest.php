<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teacher = User::factory()->create(['role' => 'teacher']);
    }

    /** @test */
    public function teacher_can_access_users_index()
    {
        $response = $this->actingAs($this->teacher)->get('/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function teacher_can_access_create_user_page()
    {
        $response = $this->actingAs($this->teacher)->get('/users/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function teacher_can_view_user_details()
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($this->teacher)->get("/users/show/{$student->id}");

        $response->assertStatus(200);
    }
}

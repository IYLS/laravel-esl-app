<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_group_relationship()
    {
        $user = new User();
        
        $this->assertTrue(method_exists($user, 'group'));
    }

    /** @test */
    public function user_has_many_comments()
    {
        $user = User::factory()->create();
        
        $this->assertTrue(method_exists($user, 'comments'));
    }

    /** @test */
    public function user_password_is_hidden()
    {
        $user = User::factory()->create(['password' => 'secret123']);
        
        $this->assertArrayNotHasKey('password', $user->toArray());
    }

    /** @test */
    public function user_can_be_created_with_fillable_attributes()
    {
        $user = User::factory()->create([
            'user_id' => 'test_user',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'student'
        ]);

        $this->assertEquals('test_user', $user->user_id);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('student', $user->role);
    }
}

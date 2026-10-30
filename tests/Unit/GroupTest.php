<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function group_belongs_to_many_units()
    {
        $group = new Group();
        
        $this->assertTrue(method_exists($group, 'units'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function group_has_many_users()
    {
        $group = new Group();
        
        $this->assertTrue(method_exists($group, 'users'));
    }
}

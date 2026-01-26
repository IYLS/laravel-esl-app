<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Unit;
use App\Models\Section;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unit_has_sections_relationship()
    {
        $unit = new Unit();
        
        $this->assertTrue(method_exists($unit, 'sections'));
    }

    /** @test */
    public function unit_has_groups_relationship()
    {
        $unit = new Unit();
        
        $this->assertTrue(method_exists($unit, 'groups'));
    }

    /** @test */
    public function unit_has_keywords_relationship()
    {
        $unit = new Unit();
        
        $this->assertTrue(method_exists($unit, 'keywords'));
    }

    /** @test */
    public function unit_has_glossed_words_relationship()
    {
        $unit = new Unit();
        
        $this->assertTrue(method_exists($unit, 'glossedWords'));
    }
}

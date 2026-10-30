<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Exercise;
use App\Models\Section;
use App\Models\ExerciseType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function exercise_belongs_to_section()
    {
        $exercise = new Exercise();
        
        $this->assertTrue(method_exists($exercise, 'section'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function exercise_belongs_to_exercise_type()
    {
        $exercise = new Exercise();
        
        $this->assertTrue(method_exists($exercise, 'exerciseType'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function exercise_has_many_questions()
    {
        $exercise = new Exercise();
        
        $this->assertTrue(method_exists($exercise, 'questions'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function exercise_has_many_feedbacks()
    {
        $exercise = new Exercise();
        
        $this->assertTrue(method_exists($exercise, 'feedbacks'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function exercise_has_one_tracking()
    {
        $exercise = new Exercise();
        
        $this->assertTrue(method_exists($exercise, 'tracking'));
    }
}

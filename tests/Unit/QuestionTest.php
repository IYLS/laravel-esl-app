<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function question_belongs_to_exercise()
    {
        $question = new Question();
        
        $this->assertTrue(method_exists($question, 'exercise'));
    }

    /** @test */
    public function question_has_many_feedbacks()
    {
        $question = new Question();
        
        $this->assertTrue(method_exists($question, 'feedbacks'));
    }

    /** @test */
    public function question_has_many_alternatives()
    {
        $question = new Question();
        
        $this->assertTrue(method_exists($question, 'alternatives'));
    }

    /** @test */
    public function question_has_one_response()
    {
        $question = new Question();
        
        $this->assertTrue(method_exists($question, 'response'));
    }
}

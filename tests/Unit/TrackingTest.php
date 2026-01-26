<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Tracking;
use App\Models\User;
use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tracking_formats_zero_seconds_correctly()
    {
        $tracking = new Tracking(['time_spent_in_seconds' => 0]);
        
        $this->assertEquals('0s', $tracking->formatted_time);
    }

    /** @test */
    public function tracking_formats_seconds_only()
    {
        $tracking = new Tracking(['time_spent_in_seconds' => 45]);
        
        $this->assertEquals('45s', $tracking->formatted_time);
    }

    /** @test */
    public function tracking_formats_minutes_and_seconds()
    {
        $tracking = new Tracking(['time_spent_in_seconds' => 125]);
        
        $this->assertEquals('02m 05s', $tracking->formatted_time);
    }

    /** @test */
    public function tracking_formats_hours_minutes_and_seconds()
    {
        $tracking = new Tracking(['time_spent_in_seconds' => 3665]);
        
        $this->assertEquals('01h 01m 05s', $tracking->formatted_time);
    }

    /** @test */
    public function tracking_formats_hours_only()
    {
        $tracking = new Tracking(['time_spent_in_seconds' => 3600]);
        
        // Cuando hay horas pero minutos y segundos son 0, solo muestra horas (no muestra 00s)
        $this->assertEquals('01h', $tracking->formatted_time);
    }

    /** @test */
    public function tracking_has_user_relationship()
    {
        $tracking = new Tracking();
        
        $this->assertTrue(method_exists($tracking, 'user'));
    }

    /** @test */
    public function tracking_has_exercise_relationship()
    {
        $tracking = new Tracking();
        
        $this->assertTrue(method_exists($tracking, 'exercise'));
    }

    /** @test */
    public function tracking_has_many_user_responses()
    {
        $tracking = new Tracking();
        
        $this->assertTrue(method_exists($tracking, 'userResponses'));
    }
}

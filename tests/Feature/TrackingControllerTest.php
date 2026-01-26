<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tracking;
use App\Models\Exercise;
use App\Models\Section;
use App\Models\Unit;
use App\Models\ExerciseType;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teacher = User::factory()->create(['role' => 'teacher']);
    }

    /** @test */
    public function teacher_can_access_tracking_index()
    {
        $response = $this->actingAs($this->teacher)->get('/tracking/index');

        $response->assertStatus(200);
    }

    /** @test */
    public function teacher_can_view_tracking_details()
    {
        $exerciseType = ExerciseType::factory()->create();
        $unit = Unit::factory()->create();
        $section = Section::factory()->create(['unit_id' => $unit->id]);
        $exercise = Exercise::factory()->create([
            'section_id' => $section->id,
            'exercise_type_id' => $exerciseType->id
        ]);
        $group = Group::factory()->create();
        $student = User::factory()->create([
            'role' => 'student',
            'group_id' => $group->id
        ]);
        $tracking = Tracking::factory()->create([
            'user_id' => $student->id,
            'exercise_id' => $exercise->id
        ]);

        $response = $this->actingAs($this->teacher)->get("/tracking/show/{$tracking->id}");

        $response->assertStatus(200);
    }
}

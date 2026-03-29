<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Section;
use App\Models\ExerciseType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition()
    {
        return [
            'section_id' => Section::factory(),
            'exercise_type_id' => ExerciseType::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'position' => $this->faker->numberBetween(1, 10),
            'subtype' => $this->faker->numberBetween(1, 4),
            'show_forum_link' => false,
            'forum_button_label' => null,
        ];
    }
}

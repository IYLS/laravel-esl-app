<?php

namespace Database\Factories;

use App\Models\ExerciseType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseTypeFactory extends Factory
{
    protected $model = ExerciseType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Multiple Choice', 'Drag and Drop', 'Fill in the Gaps', 'Open Ended']),
            'underscore_name' => $this->faker->slug(),
        ];
    }
}

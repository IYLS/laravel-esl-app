<?php

namespace Database\Factories;

use App\Models\Tracking;
use App\Models\User;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackingFactory extends Factory
{
    protected $model = Tracking::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'exercise_id' => Exercise::factory(),
            'intent_number' => $this->faker->numberBetween(1, 5),
            'time_spent_in_seconds' => $this->faker->numberBetween(0, 3600),
            'correct_answers' => $this->faker->numberBetween(0, 10),
            'wrong_answers' => $this->faker->numberBetween(0, 10),
        ];
    }
}

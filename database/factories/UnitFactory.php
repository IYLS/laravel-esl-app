<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'position' => $this->faker->numberBetween(1, 10),
            'video_name' => '', // Campo requerido pero puede estar vacío
            'listening_tips_enabled' => $this->faker->boolean(),
            'cultural_notes_enabled' => $this->faker->boolean(),
            'transcript_enabled' => $this->faker->boolean(),
            'glossary_enabled' => $this->faker->boolean(),
            'translation_enabled' => $this->faker->boolean(),
            'dictionary_enabled' => $this->faker->boolean(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition()
    {
        return [
            'unit_id' => Unit::factory(),
            'name' => $this->faker->word(),
            'underscore_name' => $this->faker->slug(),
            'position' => $this->faker->numberBetween(1, 10),
        ];
    }
}

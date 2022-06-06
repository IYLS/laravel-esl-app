<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExcerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('excercises')->insert([
            [
                'name' => 'Meet the characters!',
                'description' => ''
            ],
            [
                'name' => 'Predicting',
                'description' => ''
            ],
            [
                'name' => 'What do you hear?',
                'description' => ''
            ],
            [
                'name' => 'Vocabulary activation',
                'description' => ''
            ],
            [
                'name' => 'Vocabulary practice',
                'description' => ''
            ],
            [
                'name' => 'Drag and Drop',
                'description' => ''
            ],
            [
                'name' => 'Drag and Drop',
                'description' => ''
            ],
            [
                'name' => 'Drag and Drop',
                'description' => ''
            ],
            [
                'name' => 'Drag and Drop',
                'description' => ''
            ],
        ]);
    }
}

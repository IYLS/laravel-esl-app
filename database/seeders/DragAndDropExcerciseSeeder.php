<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DragAndDropExcerciseSeeder extends Seeder
{
    public function run()
    {
        DB::table('drag_and_drop_excercises')->insert([
            [            
                'id' => 21,
                'title' => 'Vocabulary activation',
                'description' => 'Ejercicio de agarrar, arrastrar y soltar.',
                'type' => 'drag_and_drop',
                'section_id' => 1
            ],
            [            
                'id' => 10,
                'title' => 'Vocabulary activation',
                'description' => 'Ejercicio de agarrar, arrastrar y soltar.',
                'type' => 'drag_and_drop',
                'section_id' => 2
            ],
        ]);
    }
}

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
                'id' => 489,
                'title' => 'Vocabulary activation',
                'description' => 'Ejercicio de agarrar, arrastrar y soltar.',
                'section' => 'pre_listening',
                'type' => 'drag_and_drop',
                'unit_id' => 764
            ],
            [            
                'id' => 289,
                'title' => 'Vocabulary activation',
                'description' => 'Ejercicio de agarrar, arrastrar y soltar.',
                'section' => 'pre_listening',
                'type' => 'drag_and_drop',
                'unit_id' => 764
            ],
            ]);
    }
}

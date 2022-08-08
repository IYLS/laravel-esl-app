<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DragAndDropQuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('drag_and_drop_questions')->insert([
            [            
                'id' => 21,
                'word' => 'Walter Jr',
                'definition' => 'Kid with impaired motor control',
                'excercise_id' => 21
            ],
            [            
                'id' => 34,
                'word' => 'Walter White',
                'definition' => 'Bald man with hat',
                'excercise_id' => 21
            ],
        ]);
    }
}

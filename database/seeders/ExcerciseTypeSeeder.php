<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExcerciseTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('excercise_types')->insert([
            [            
                'id' => 1,
                'name' => 'Drag and Drop',
                'underscore_name' => 'drag_and_drop',
                'description' => '',
            ],
            [            
                'id' => 2,
                'name' => 'Multiple choice',
                'underscore_name' => 'multiple_choice',
                'description' => '',
            ],
            [            
                'id' => 3,
                'name' => 'Fill in the gaps',
                'underscore_name' => 'fill_in_the_gaps',
                'description' => '',
            ],
            [            
                'id' => 4,
                'name' => 'Open ended',
                'underscore_name' => 'open_ended',
                'description' => '',
            ],
            [            
                'id' => 5,
                'name' => 'Voice Recognition',
                'underscore_name' => 'voice_recognition',
                'description' => '',
            ],
        ]);
    }
}
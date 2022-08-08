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
                'id' => 1,
                'word' => 'seem',
                'definition' => 'Something that is incorrect or not true.',
                'excercise_id' => 21
            ],
            [            
                'id' => 2,
                'word' => 'wrong',
                'definition' => 'To become completely healthy again after an illness or injury.',
                'excercise_id' => 21
            ],
            [            
                'id' => 3,
                'word' => 'lasting',
                'definition' => 'To make or become well again, especially after an injury.',
                'excercise_id' => 21
            ],
            [            
                'id' => 4,
                'word' => 'races',
                'definition' => 'To appear to be.',
                'excercise_id' => 21
            ],
            [            
                'id' => 5,
                'word' => 'healed',
                'definition' => 'To become or cause someone to be extremely emotional.',
                'excercise_id' => 21
            ],
            [            
                'id' => 6,
                'word' => 'recover',
                'definition' => 'Something that continues to exist for a long time or forever.',
                'excercise_id' => 21
            ],
            [            
                'id' => 7,
                'word' => 'freak out',
                'definition' => 'To move or go fast.',
                'excercise_id' => 21
            ],
        ]);
    }
}

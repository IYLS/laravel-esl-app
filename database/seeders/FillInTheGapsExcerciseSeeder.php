<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class FillInTheGapsExcerciseSeeder extends Seeder
{
    public function run()
    {
        DB::table('fill_in_the_gaps_excercises')->insert([
            [            
                'id' => 21,
                'title' => 'Dictation cloze',
                'description' => 'Listen to the audio extract and complete the missing words from the text (1 word per space).',
                'type' => 'fill_in_the_gaps',
                'subtype' => 1,
                'section_id' => 2
            ],
            [            
                'id' => 22,
                'title' => 'Vocabulary practice',
                'description' => 'Put the words in the correct sentences',
                'type' => 'fill_in_the_gaps',
                'subtype' => 2,
                'section_id' => 2
            ]
        ]);
    }
}

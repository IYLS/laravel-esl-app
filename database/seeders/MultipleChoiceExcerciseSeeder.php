<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MultipleChoiceExcerciseSeeder extends Seeder
{
    public function run()
    {
        DB::table('multiple_choice_excercises')->insert([
            [            
                'id' => 93,
                'title' => 'Predicting',
                'description' => '',
                'instructions' => 'The pictures summarize the video. Read the predictions below and choose the letter that best
                represents what you think will happen.',
                'image_name' => 'steven_universe.png',
                'video_name' => 'n1t2.mp4',
                'type' => 'multiple_choice',
                'subtype' => 1,
                'section_id' => 1
            ],
            [            
                'id' => 16,
                'title' => 'What do you hear?',
                'description' => 'Listen to the audio extract and select the word you hear.',
                'instructions' => '',
                'image_name' => 'FdaSPOVrX2KSfHbYpLoDg5bHTjq0p50c152oGIGr.jpg',
                'video_name' => 'n1t2.mp4',
                'type' => 'multiple_choice',
                'subtype' => 2,
                'section_id' => 1
            ],
            [            
                'id' => 17,
                'title' => 'Evaluating Statement',
                'description' => 'Read each statement carefully. Decide whether the statements are TRUE/FALSE or mark I’M NOT SURE if you do not know the answer',
                'instructions' => '',
                'image_name' => '',
                'video_name' => '',
                'type' => 'multiple_choice',
                'subtype' => 3,
                'section_id' => 2
            ],
            [            
                'id' => 18,
                'title' => 'Multiple choice',
                'description' => 'Read the questions and answer',
                'instructions' => '',
                'image_name' => '',
                'video_name' => '',
                'type' => 'multiple_choice',
                'subtype' => 4,
                'section_id' => 3
            ],
        ]);
    }
}
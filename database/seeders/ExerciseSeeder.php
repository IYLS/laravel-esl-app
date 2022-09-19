<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        DB::table('exercises')->insert([
            [            
                'id' => 11,
                'title' => 'Vocabulary activation',
                'description' => 'Match the words with their correct definition. Check the previous exercise to understand the context of the words',
                'instructions' => null,
                'subtype' => null,
                'image_name' => null,
                'video_name' => null,
                'section_id' => 1,
                'exercise_type_id' => 1
            ],
            [            
                'id' => 12,
                'title' => 'Predicting',
                'description' => null,
                'instructions' => 'The pictures summarize the video. Read the predictions below and choose the letter that best represents what you think will happen.',
                'image_name' => 'steven_universe.png',
                'video_name' => 'n1t2.mp4',
                'subtype' => 1,
                'section_id' => 1,
                'exercise_type_id' => 2
            ],
            [            
                'id' => 13,
                'title' => 'What do you hear?',
                'description' => 'Listen to the audio extract and select the word you hear.',
                'instructions' => null,
                'image_name' => 'FdaSPOVrX2KSfHbYpLoDg5bHTjq0p50c152oGIGr.jpg',
                'video_name' => 'n1t2.mp4',
                'subtype' => 2,
                'section_id' => 1,
                'exercise_type_id' => 2
            ],
            [            
                'id' => 14,
                'title' => 'Evaluating Statement',
                'description' => 'Read each statement carefully. Decide whether the statements are TRUE/FALSE or mark I’M NOT SURE if you do not know the answer',
                'instructions' => null,
                'image_name' => null,
                'video_name' => null,
                'subtype' => 3,
                'section_id' => 2,
                'exercise_type_id' => 2
            ],
            [            
                'id' => 15,
                'title' => 'Multiple choice',
                'description' => 'Read the questions and answer',
                'instructions' => null,
                'image_name' => null,
                'video_name' => null,
                'subtype' => 4,
                'section_id' => 3,
                'exercise_type_id' => 2
            ],
            [            
                'id' => 16,
                'title' => 'Meet the characters',
                'description' => 'Listen the audio pieces to know the characters',
                'instructions' => null,
                'image_name' => null,
                'video_name' => null,
                'subtype' => null,
                'section_id' => 1,
                'exercise_type_id' => 5
            ],
            [            
                'id' => 17,
                'title' => 'Personal response',
                'description' => 'Answer the question',
                'instructions' => null,
                'image_name' => null,
                'video_name' => null,
                'subtype' => null,
                'section_id' => 3,
                'exercise_type_id' => 4
            ],
            [            
                'id' => 18,
                'title' => 'Dictation cloze',
                'description' => 'Listen to the audio extract and complete the missing words from the text (1 word per space).',
                'instructions' => null,
                'image_name' => null,
                'video_name' => null,
                'subtype' => 1,
                'section_id' => 2,
                'exercise_type_id' => 3
            ],
            [            
                'id' => 19,
                'title' => 'Vocabulary practice',
                'description' => 'Put the words in the correct sentences',
                'instructions' => null,
                'image_name' => null,
                'video_name' => null,
                'subtype' => 2,
                'section_id' => 2,
                'exercise_type_id' => 3
            ]
        ]);
    }
}

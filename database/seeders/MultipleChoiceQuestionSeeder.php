<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MultipleChoiceQuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('multiple_choice_questions')->insert([
            [            
                'id' => 14,
                'statement' => 'Steven is anxious about his physical and mental health.;The Doctor is trying to help Steven.;Steven looks healthy and buff.;The Doctor is worried about Steven.',
                'audio_name' => 'dictation_cloze.mp3',
                'excercise_id' => 93
            ],
            [            
                'id' => 1,
                'statement' => 'It almost looks as if the bones ;; themselves the instant the injuries occurred',
                'audio_name' => '1.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 2,
                'statement' => 'Well, you ;; to have made a series of miraculous recoveries.  ',
                'audio_name' => '2.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 3,
                'statement' => 'Have you ;; mentally?',
                'audio_name' => '3.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 4,
                'statement' => 'You think there’s something ;; with my brain?',
                'audio_name' => '4.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 5,
                'statement' => 'Childhood trauma can have a ;; impact on how your body responds to stress. ',
                'audio_name' => '5.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 6,
                'statement' => 'The brain releases the hormone cortisol, your heart ;;, your muscles tense.',
                'audio_name' => '6.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 7,
                'statement' => 'I kinda ;; when they canceled my favorite ice cream.',
                'audio_name' => '7.mp3',
                'excercise_id' => 16
            ],
            [            
                'id' => 8,
                'statement' => 'Steven’s body has suffered numerous fractures.',
                'audio_name' => null,
                'excercise_id' => 17
            ],
            [            
                'id' => 9,
                'statement' => 'Steven’s bones recovered normally.',
                'audio_name' => null,
                'excercise_id' => 17
            ],
            [            
                'id' => 10,
                'statement' => 'Steven has not experienced trauma.',
                'audio_name' => null,
                'excercise_id' => 17
            ],
            [            
                'id' => 11,
                'statement' => 'Bad childhood experiences affect our mind and body.',
                'audio_name' => null,
                'excercise_id' => 17
            ],
            [            
                'id' => 12,
                'statement' => 'Cortisol is released when we are happy.',
                'audio_name' => null,
                'excercise_id' => 17
            ],
            [            
                'id' => 13,
                'statement' => 'Steven remembers a lot of bad things that happened in his childhood.',
                'audio_name' => null,
                'excercise_id' => 17
            ],
            [            
                'id' => 15,
                'statement' => 'Have you experienced your heart racing and/or your muscles tense because you are anxious?',
                'audio_name' => null,
                'excercise_id' => 18
            ],
        ]);
    }
}
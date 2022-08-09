<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class FillInTheGapsQuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('fill_in_the_gaps_questions')->insert([
            [            
                'id' => 1,
                'statement' => "Not wrong... it's that adverse childhood experiences or childhood ;; can have a lasting impact on how your body ;; to stress. This can affect your social, emotional, and physical development. When humans are in crisis, the brain releases the ;; cortisol, your heart races, your muscles tense... I wonder if your body is reacting to a gem equivalent of ;;. Steven, do you remember anything bad in your ;;  that particularly stuck with you?",
                'audio_name' => 'Steven_dictation.mp3',
                'matching_word' => null,
                'excercise_id' => 21
            ],
            [            
                'id' => 2,
                'statement' => "I believe that ;; friendships are the best.",
                'audio_name' => null,
                'matching_word' => 'lasting',
                'excercise_id' => 22
            ],
            [            
                'id' => 3,
                'statement' => "I think my mom will ;; when she sees my grades.",
                'audio_name' => null,
                'matching_word' => 'freak out',
                'excercise_id' => 22
            ],
            [            
                'id' => 4,
                'statement' => "My sister wants to ;; soon to go out to play.",
                'audio_name' => null,
                'matching_word' => 'recover',
                'excercise_id' => 22
            ],
            [            
                'id' => 5,
                'statement' => "I ;; be taller than last month. ",
                'audio_name' => null,
                'matching_word' => 'seem to',
                'excercise_id' => 22
            ],
            [            
                'id' => 6,
                'statement' => "You have the ;; answer. It is option number 1, not 2.",
                'audio_name' => null,
                'matching_word' => 'wrong',
                'excercise_id' => 22
            ],
            [            
                'id' => 7,
                'statement' => "He ;; to school every morning on his bicycle.",
                'audio_name' => null,
                'matching_word' => 'races',
                'excercise_id' => 22
            ],
            [            
                'id' => 8,
                'statement' => "My bones ;; really well in just a few months!",
                'audio_name' => null,
                'matching_word' => 'healed',
                'excercise_id' => 22
            ],
        ]);
    }
}
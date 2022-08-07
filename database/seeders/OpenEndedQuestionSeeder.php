<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class OpenEndedQuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('open_ended_questions')->insert([
            [            
                'id' => 8,
                'title' => "Hank, Walt's brother-in-law, is a DEA agent. What does DEA stand for?",
                'answer' => null,
                'excercise_id' => 29
            ],
            [            
                'id' => 5,
                'title' => "Walter White's transformation from nerdy high school chemistry teacher to criminal kingpin all started with what specific medical diagnosis?",
                'answer' => null,
                'excercise_id' => 29
            ],
        ]);    
    }
}

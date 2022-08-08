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
                'title' => "Imagine Steven is your friend and he is feeling bad. What do you want to tell him to make him feel better? Read the examples and write a message for him.",
                'answer' => null,
                'excercise_id' => 29
            ],
        ]);    
    }
}

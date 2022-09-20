<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedback')->insert([
            [            
                'id' => 4982,
                'message' => 'Good Job!',
                'audio_name' => null,
                'feedback_type_id' => 1,
                'exercise_id' => 14,
                'question_id' => 51
            ],
        ]);
    }
}

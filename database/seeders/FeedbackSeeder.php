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
                'id' => 8,
                'audio_name' => '3.mp3',
                'message' => 'You can check if your prediction is right in the While-listening section!',
                'exercise_id' => 12,
                'question_id' => null,
                'feedback_type_id' => 1
            ],
            [
                'id' => 9,
                'audio_name' => null,
                'message' => 'Well done!',
                'exercise_id' => 15,
                'question_id' => null,
                'feedback_type_id' => 2
            ],
            [
                'id' => 14,
                'audio_name' => null,
                'message' => 'Well done!',
                'exercise_id' => 11,
                'question_id' => null,
                'feedback_type_id' => 2
            ],
            [
                'id' => 10,
                'audio_name' => null,
                'message' => 'Try again. You can check the What do you hear? exercise to see the context of the words.',
                'exercise_id' => 11,
                'question_id' => null,
                'feedback_type_id' => 4
            ],
            [
                'id' => 11,
                'audio_name' => null,
                'message' => 'Thanks for sharing your experience.',
                'exercise_id' => 15,
                'question_id' => null,
                'feedback_type_id' => 1
            ]
        ]);
    }
}

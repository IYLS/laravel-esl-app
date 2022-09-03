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
                'id' => 1,
                'message' => 'Good Job!',
                'audio_name' => null,
                'feedback_type_id' => 1,
                'excercise_id' => 14,
            ],
        ]);
    }
}

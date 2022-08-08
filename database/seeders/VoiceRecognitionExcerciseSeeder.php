<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class VoiceRecognitionExcerciseSeeder extends Seeder
{
    public function run()
    {
        DB::table('voice_recognition_excercises')->insert([
            [            
                'id' => 41,
                'title' => 'Meet the characters',
                'description' => 'Listen the audio pieces to know the characters',
                'type' => 'voice_recognition',
                'section_id' => 1
            ]
        ]);
    }
}

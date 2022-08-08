<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class VoiceRecognitionQuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('voice_recognition_questions')->insert([
            [            
                'id' => 81,
                'image_url' => 'public/files/19gfddeoo3eP0QJDQHgTwUV99IjmP0bRISlH0jhw.jpg',
                'image_name' => 'Doctor.jpg',
                'audio_url' => 'public/files/dictation_cloze.mp3',
                'audio_name' => 'Doctor.mp3',
                'title' => 'Doctor',
                'excercise_id' => 41
            ],
            [            
                'id' => 82,
                'image_url' => 'public/files/19gfddeoo3eP0QJDQHgTwUV99IjmP0bRISlH0jhw.jpg',
                'image_name' => 'Steven.jpg',
                'audio_url' => 'public/files/dictation_cloze.mp3',
                'audio_name' => 'Steven.mp3',
                'title' => 'Steven',
                'excercise_id' => 41
            ],
        ]);
    }
}

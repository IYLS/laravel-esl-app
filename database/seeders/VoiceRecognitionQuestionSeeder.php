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
                'image_name' => '19gfddeoo3eP0QJDQHgTwUV99IjmP0bRISlH0jhw.jpg',
                'audio_url' => 'public/files/dictation_cloze.mp3',
                'audio_name' => 'dictation_cloze.mp3',
                'title' => 'Soft Electronics Talk 1',
                'excercise_id' => 41
            ],
            [            
                'id' => 82,
                'image_url' => 'public/files/19gfddeoo3eP0QJDQHgTwUV99IjmP0bRISlH0jhw.jpg',
                'image_name' => '19gfddeoo3eP0QJDQHgTwUV99IjmP0bRISlH0jhw.jpg',
                'audio_url' => 'public/files/dictation_cloze.mp3',
                'audio_name' => 'dictation_cloze.mp3',
                'title' => 'Dictation Cloze talk 5',
                'excercise_id' => 41
            ],
        ]);
    }
}

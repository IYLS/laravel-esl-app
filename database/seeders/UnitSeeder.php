<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UnitSeeder extends Seeder
{
    public function run()
    {
        DB::table('units')->insert([
            [   
                'id' => 764,
                'title' => "Steven's Universe",
                'author' => 'Roozbeh Ghaffari',
                'description' => 'This unit is about music',
                'listening_tips' => 'asd',
                'cultural_notes' => 'asd',
                'transcript' => 'asd',
                'translation' => 'asd',
                'glossary' => 'asd',
                'dictionary' => 'asd',
                'listening_tips_enabled' => true,
                'cultural_notes_enabled' => true,
                'transcript_enabled' => true,
                'translation_enabled' => true,
                'glossary_enabled' => true,
                'dictionary_enabled' => true,
                'video_url' => 'public/files/n1t2.mp4',
                'video_name' => 'Steven_raw.mp4'
            ],
            [   
                'id' => 1034,
                'title' => "Talk 2 - Soft Electronics",
                'author' => 'Roozbeh Ghaffari',
                'description' => 'This unit is about soft electronics',
                'listening_tips' => 'asd',
                'cultural_notes' => 'asd',
                'transcript' => 'asd',
                'translation' => 'asd',
                'glossary' => 'asd',
                'dictionary' => 'asd',
                'listening_tips_enabled' => true,
                'cultural_notes_enabled' => true,
                'transcript_enabled' => true,
                'translation_enabled' => true,
                'glossary_enabled' => true,
                'dictionary_enabled' => true,
                'video_url' => 'public/files/n1t3.mp4',
                'video_name' => 'n1t3.mp4'
            ],
            [   
                'id' => 1033,
                'title' => 'Unidad 3',
                'author' => 'Benjamin Caceres',
                'description' => 'This unit is about soft electronics',
                'listening_tips' => 'asd',
                'cultural_notes' => 'asd',
                'transcript' => 'asd',
                'translation' => 'asd',
                'glossary' => 'asd',
                'dictionary' => 'asd',
                'listening_tips_enabled' => true,
                'cultural_notes_enabled' => true,
                'transcript_enabled' => true,
                'translation_enabled' => true,
                'glossary_enabled' => true,
                'dictionary_enabled' => true,
                'video_url' => 'public/files/n1t5.mp4',
                'video_name' => 'n1t5.mp4'
            ],
        ]);
    }
}
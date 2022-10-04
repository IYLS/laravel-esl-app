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
                'author' => 'Belén Cáceres',
                'description' => '',
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
                'video_name' => 'Steven_raw.mp4'
            ],
        ]);
    }
}
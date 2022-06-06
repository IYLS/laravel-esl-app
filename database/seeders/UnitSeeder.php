<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            [   'title' => 'Talk 1 - Music',
                'author' => 'Roozbeh Ghaffari',
                'description' => 'asd',
                'listening_tips' => 'asd',
                'cultural_notes' => 'asd',
                'transcript' => 'asd',
                'translation' => 'asd',
                'glossary' => 'asd',
                'dictionary' => 'asd',
                'group_id' => 1,
            ],
            [   
                'title' => 'Talk 2 - Soft Electronics',
                'author' => 'Roozbeh Ghaffari',
                'description' => 'asd',
                'listening_tips' => 'asd',
                'cultural_notes' => 'asd',
                'transcript' => 'asd',
                'translation' => 'asd',
                'glossary' => 'asd',
                'dictionary' => 'asd',
                'group_id' => 1,
            ],
        ]);
    }
}

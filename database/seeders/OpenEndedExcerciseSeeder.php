<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class OpenEndedExcerciseSeeder extends Seeder
{
    public function run()
    {
        DB::table('open_ended_excercises')->insert([
            [            
                'id' => 29,
                'title' => 'Personal response',
                'description' => '',
                'type' => 'open_ended',
                'section_id' => 1
            ],
        ]);
    }
}

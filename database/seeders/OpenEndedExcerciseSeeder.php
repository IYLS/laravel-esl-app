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
                'title' => 'Explain',
                'description' => 'Explain your thoughts',
                'type' => 'open_ended',
                'section_id' => 1
            ],
            [            
                'id' => 95,
                'title' => 'Explain',
                'description' => 'Explain your thoughts',
                'type' => 'open_ended',
                'section_id' => 2
            ],
        ]);    
    }
}

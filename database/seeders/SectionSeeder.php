<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SectionSeeder extends Seeder
{
    public function run()
    {
        DB::table('sections')->insert([
            [            
                'id' => 1,
                'name' => 'Pre Listening',
                'instructions' => 'Prepare for listening: In this session, you will watch a video about Steven going to the doctor for the first time. It seems that he has suffered both emotional and physical trauma. Read the instructions carefully and complete the following exercises.',
                'underscore_name' => 'pre_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 2,
                'name' => 'While Listening',
                'instructions' => 'Context: You will watch a video about Steven going to the doctor for the first time. It seems that he has suffered both emotional and physical trauma. Listen carefully and answer the following questions.',
                'underscore_name' => 'while_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 3,
                'name' => 'Post Listening',
                'instructions' => '',
                'underscore_name' => 'post_listening',
                'unit_id' => 764
            ],
        ]);
    }
}
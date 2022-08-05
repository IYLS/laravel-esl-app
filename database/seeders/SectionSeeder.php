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
                'name' => 'pre_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 2,
                'name' => 'while_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 3,
                'name' => 'post_listening',
                'unit_id' => 764
            ],
        ]);
    }
}
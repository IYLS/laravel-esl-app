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
                'underscore_name' => 'pre_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 2,
                'name' => 'While Listening',
                'underscore_name' => 'while_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 3,
                'name' => 'Post Listening',
                'underscore_name' => 'post_listening',
                'unit_id' => 764
            ],
            [            
                'id' => 4,
                'name' => 'Pre Listening',
                'underscore_name' => 'pre_listening',
                'unit_id' => 1034
            ],
            [            
                'id' => 5,
                'name' => 'While Listening',
                'underscore_name' => 'while_listening',
                'unit_id' => 1034
            ],
            [            
                'id' => 6,
                'name' => 'Post Listening',
                'underscore_name' => 'post_listening',
                'unit_id' => 1034
            ],
            [            
                'id' => 7,
                'name' => 'Pre Listening',
                'underscore_name' => 'pre_listening',
                'unit_id' => 1033
            ],
            [            
                'id' => 8,
                'name' => 'While Listening',
                'underscore_name' => 'while_listening',
                'unit_id' => 1033
            ],
            [            
                'id' => 9,
                'name' => 'Post Listening',
                'underscore_name' => 'post_listening',
                'unit_id' => 1033
            ],
        ]);
    }
}
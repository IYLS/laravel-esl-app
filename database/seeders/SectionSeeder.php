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
            [            
                'id' => 4,
                'name' => 'pre_listening',
                'unit_id' => 9078
            ],
            [            
                'id' => 5,
                'name' => 'while_listening',
                'unit_id' => 9078
            ],
            [            
                'id' => 6,
                'name' => 'post_listening',
                'unit_id' => 9078
            ],
            [            
                'id' => 7,
                'name' => 'pre_listening',
                'unit_id' => 7645
            ],
            [            
                'id' => 8,
                'name' => 'while_listening',
                'unit_id' => 7645
            ],
            [            
                'id' => 9,
                'name' => 'post_listening',
                'unit_id' => 7645
            ],
        ]);
    }
}
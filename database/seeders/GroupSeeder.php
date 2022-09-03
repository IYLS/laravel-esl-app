<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    public function run()
    {
        DB::table('groups')->insert([
            [
                'id' => 345,
                'name' => '7°B'
            ],
            [
                'id' => 645,
                'name' => '4°A'
            ],
            [
                'id' => 9964,
                'name' => '4°C'
            ],
            [
                'id' => 3564,
                'name' => '5°A'
            ]
        ]);
    }
}

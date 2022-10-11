<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitGroupSeeder extends Seeder
{
    public function run()
    {
        DB::table('unit_group')->insert([
            [
                'unit_id' => 764,
                'group_id' => 345
            ],
            [
                'unit_id' => 764,
                'group_id' => 645
            ],
            [
                'unit_id' => 764,
                'group_id' => 783
            ],
        ]);
    }
}
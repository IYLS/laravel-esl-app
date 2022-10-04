<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KeywordSeeder extends Seeder
{
    public function run()
    {
        DB::table('keywords')->insert(
        [
            [
                'keyword' => Str::random(10),
                'description' => Str::random(40),
                'unit_id' => 764,
            ],
            [
                'keyword' => Str::random(10),
                'description' => Str::random(40),
                'unit_id' => 764,
            ]
        ]);
    }
}

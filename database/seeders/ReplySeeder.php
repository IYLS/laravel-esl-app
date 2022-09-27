<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ReplySeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([]);
    }
}

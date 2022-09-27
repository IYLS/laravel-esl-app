<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->insert([
            [
                'id' => 9,
                'title' => "Steven's Universe unit is so hard!",
                'content' => "I've been working really hard and I'm stuck on the second activity.",
                'user_id' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'group_id' => 345
            ],
            [
                'id' => 10,
                'title' => "Steven's Universe unit is so hard!",
                'content' => "I've been working really hard and I'm stuck on the second activity.",
                'user_id' => 6,
                'created_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
                'group_id' => 345
            ],
        ]);
    }
}

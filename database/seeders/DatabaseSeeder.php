<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(KeywordSeeder::class);
        $this->call(UnitGroupSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(ExcerciseSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(AlternativeSeeder::class);
        $this->call(FeedbackTypeSeeder::class);
        $this->call(FeedbackSeeder::class);
    }
}
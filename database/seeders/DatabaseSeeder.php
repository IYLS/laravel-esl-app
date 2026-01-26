<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Asegurar que la conexión use UTF-8
        DB::statement('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
        
        $this->call(ExerciseTypeSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ReplySeeder::class);
        $this->call(KeywordSeeder::class);
        $this->call(UnitGroupSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(AlternativeSeeder::class);
        $this->call(FeedbackTypeSeeder::class);
        $this->call(FeedbackSeeder::class);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Asegurar que la conexión use UTF-8 (solo para MySQL)
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
        } elseif ($driver === 'pgsql') {
            // PostgreSQL ya usa UTF-8 por defecto, pero podemos asegurarlo
            DB::statement("SET client_encoding TO 'UTF8'");
        }
        
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
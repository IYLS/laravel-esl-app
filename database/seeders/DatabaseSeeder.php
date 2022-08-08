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
        $this->call(MultipleChoiceExcerciseSeeder::class);
        $this->call(MultipleChoiceQuestionSeeder::class);
        $this->call(MultipleChoiceAlternativeSeeder::class);
        $this->call(VoiceRecognitionExcerciseSeeder::class);
        $this->call(VoiceRecognitionQuestionSeeder::class);
        $this->call(FillInTheGapsExcerciseSeeder::class);
        $this->call(FillInTheGapsQuestionSeeder::class);
        $this->call(DragAndDropExcerciseSeeder::class);
        $this->call(DragAndDropQuestionSeeder::class);
        $this->call(OpenEndedExcerciseSeeder::class);
        $this->call(OpenEndedQuestionSeeder::class);
    }
}
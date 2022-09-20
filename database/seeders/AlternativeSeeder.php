<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class AlternativeSeeder extends Seeder
{
    public function run()
    {
        DB::table('alternatives')->insert([
            [            
                'id' => 14,
                'title' => 'Only I',
                'correct_alt' => true,
                'question_id' => 14
            ],
            [
                'id' => 16,
                'title' => 'II & III',
                'correct_alt' => false,
                'question_id' => 14
            ],
            [
                'id' => 17,
                'title' => 'I, II & III',
                'correct_alt' => false,
                'question_id' => 14
            ],
            [            
                'id' => 21,
                'title' => 'I, II & IV',
                'correct_alt' => false,
                'question_id' => 14
            ],
            [            
                'id' => 22,
                'title' => 'healed',
                'correct_alt' => true,
                'question_id' => 51
            ],
            [            
                'id' => 23,
                'title' => 'heel',
                'correct_alt' => false,
                'question_id' => 51
            ],
            [            
                'id' => 24,
                'title' => 'see',
                'correct_alt' => false,
                'question_id' => 52
            ],
            [            
                'id' => 25,
                'title' => 'seem',
                'correct_alt' => true,
                'question_id' => 52
            ],
            [            
                'id' => 26,
                'title' => 'recorded',
                'correct_alt' => false,
                'question_id' => 53
            ],
            [
                'id' => 27,
                'title' => 'recovered',
                'correct_alt' => true,
                'question_id' => 53
            ],
            [
                'id' => 28,
                'title' => 'wrong',
                'correct_alt' => true,
                'question_id' => 54
            ],
            [            
                'id' => 29,
                'title' => 'long',
                'correct_alt' => false,
                'question_id' => 54
            ],
            [
                'id' => 30,
                'title' => 'laughing',
                'correct_alt' => false,
                'question_id' => 55
            ],
            [
                'id' => 31,
                'title' => 'lasting',
                'correct_alt' => true,
                'question_id' => 55
            ],
            [
                'id' => 32,
                'title' => 'rice',
                'correct_alt' => false,
                'question_id' => 56
            ],
            [
                'id' => 33,
                'title' => 'races',
                'correct_alt' => true,
                'question_id' => 56
            ],
            [
                'id' => 34,
                'title' => 'freaked out',
                'correct_alt' => true,
                'question_id' => 57
            ],
            [
                'id' => 35,
                'title' => 'found out',
                'correct_alt' => false,
                'question_id' => 57
            ],
            [
                'id' => 36,
                'title' => "Yes, I have experienced it. It's terrible.",
                'correct_alt' => true,
                'question_id' => 15
            ],
            [
                'id' => 37,
                'title' => 'No, I have not experienced it, thankfully.',
                'correct_alt' => true,
                'question_id' => 15
            ],
            [
                'id' => 38,
                'title' => "I'm not sure. Maybe I have experienced it.",
                'correct_alt' => true,
                'question_id' => 15
            ],
        ]);
    }
}

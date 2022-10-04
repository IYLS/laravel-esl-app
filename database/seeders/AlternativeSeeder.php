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
            [
                'id' => 39,
                'title' => "I am focused and ready to start this lesson.",
                'correct_alt' => false,
                'question_id' => 93
            ],
            [
                'id' => 40,
                'title' => "I have all the materials and equipment I need for the lesson.",
                'correct_alt' => false,
                'question_id' => 93
            ],
            [
                'id' => 41,
                'title' => "I am free of distractions.",
                'correct_alt' => false,
                'question_id' => 93
            ],
            [
                'id' => 42,
                'title' => "My predictions were completely right.",
                'correct_alt' => false,
                'question_id' => 101
            ],
            [
                'id' => 43,
                'title' => "My predictions were partially right.",
                'correct_alt' => false,
                'question_id' => 101
            ],
            [
                'id' => 44,
                'title' => "My predictions were incorrect.",
                'correct_alt' => false,
                'question_id' => 101
            ],
            [
                'id' => 45,
                'title' => "I understood most of the video.",
                'correct_alt' => false,
                'question_id' => 102
            ],
            [
                'id' => 46,
                'title' => "I understood some segments of the video.",
                'correct_alt' => false,
                'question_id' => 102
            ],
            [
                'id' => 47,
                'title' => "I did not understand the video at all.",
                'correct_alt' => false,
                'question_id' => 102
            ],
            [
                'id' => 48,
                'title' => "I did well and I can explain what the text is about to other people.",
                'correct_alt' => false,
                'question_id' => 103
            ],
            [
                'id' => 49,
                'title' => "I did ok, but I would need to listen again more carefully.",
                'correct_alt' => false,
                'question_id' => 103
            ],
            [
                'id' => 50,
                'title' => " I did poorly,  but I think I would do better with more practice.",
                'correct_alt' => false,
                'question_id' => 103
            ],





            [
                'id' => 51,
                'title' => "The text was too fast.",
                'correct_alt' => false,
                'question_id' => 104
            ],
            [
                'id' => 52,
                'title' => " I did not know most of the vocabulary.",
                'correct_alt' => false,
                'question_id' => 104
            ],
            [
                'id' => 53,
                'title' => "Accent was difficult to understand.",
                'correct_alt' => false,
                'question_id' => 104
            ],            [
                'id' => 54,
                'title' => "I watched the video.",
                'correct_alt' => false,
                'question_id' => 105
            ],
            [
                'id' => 55,
                'title' => "I turned on the captions.",
                'correct_alt' => false,
                'question_id' => 105
            ],
            [
                'id' => 56,
                'title' => "I read the transcript.",
                'correct_alt' => false,
                'question_id' => 105
            ],
            [
                'id' => 57,
                'title' => "I used the subtitles.",
                'correct_alt' => false,
                'question_id' => 105
            ],
            [
                'id' => 58,
                'title' => "I read the transcript before listening to the text.",
                'correct_alt' => false,
                'question_id' => 106
            ],
            [
                'id' => 59,
                'title' => " I read the transcript and listen to the video simultaneously.",
                'correct_alt' => false,
                'question_id' => 106
            ],
            [
                'id' => 60,
                'title' => " I read the captions as I watched the video.",
                'correct_alt' => false,
                'question_id' => 106
            ],
            [
                'id' => 61,
                'title' => "I read the subtitles to confirm ",
                'correct_alt' => false,
                'question_id' => 106
            ],
        ]);
    }
}

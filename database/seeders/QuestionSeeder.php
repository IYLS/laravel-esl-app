<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([
            [            
                'id' => 51,
                'statement' => 'It almost looks as if the bones ;; themselves the instant the injuries occurred',
                'audio_name' => '1.mp3',
                'answer' => null,
                'image_name' => null,
                'correct_answer' => 'healed',
                'exercise_id' => 13
            ],
            [            
                'id' => 52,
                'statement' => 'Well, you ;; to have made a series of miraculous recoveries.  ',
                'audio_name' => '2.mp3',
                'answer' => null,
                'image_name' => null,
                'correct_answer' => 'seem',
                'exercise_id' => 13
            ],
            [            
                'id' => 53,
                'statement' => 'Have you ;; mentally?',
                'audio_name' => '3.mp3',
                'answer' => null,
                'image_name' => null,
                'correct_answer' => 'recovered',
                'exercise_id' => 13
            ],
            [            
                'id' => 54,
                'statement' => 'You think there’s something ;; with my brain?',
                'audio_name' => '4.mp3',
                'answer' => null,
                'image_name' => null,
                'correct_answer' => 'wrong',
                'exercise_id' => 13
            ],
            [            
                'id' => 55,
                'statement' => 'Childhood trauma can have a ;; impact on how your body responds to stress. ',
                'answer' => null,
                'image_name' => null,
                'audio_name' => '5.mp3',
                'correct_answer' => 'lasting',
                'exercise_id' => 13
            ],
            [            
                'id' => 56,
                'statement' => 'The brain releases the hormone cortisol, your heart ;;, your muscles tense.',
                'audio_name' => '6.mp3',
                'answer' => null,
                'image_name' => null,
                'correct_answer' => 'races',
                'exercise_id' => 13
            ],
            [            
                'id' => 57,
                'statement' => 'I kinda ;; when they canceled my favorite ice cream.',
                'audio_name' => '7.mp3',
                'answer' => null,
                'image_name' => null,
                'correct_answer' => 'freaked out',
                'exercise_id' => 13
            ],
            [
                'id' => 58,
                'statement' => "Steven’s body has suffered numerous fractures.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'true',
                'exercise_id' => 14
            ],
            [
                'id' => 59,
                'statement' => "Steven’s bones recovered normally.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'false',
                'exercise_id' => 14
            ],
            [
                'id' => 10,
                'statement' => "Steven has not experienced trauma.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'false',
                'exercise_id' => 14
            ],
            [
                'id' => 11,
                'statement' => "Bad childhood experiences affect our mind and body.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'true',
                'exercise_id' => 14
            ],
            [
                'id' => 12,
                'statement' => "Cortisol is released when we are happy.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'false',
                'exercise_id' => 14
            ],
            [
                'id' => 13,
                'statement' => "Steven remembers a lot of bad things that happened in his childhood.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'false',
                'exercise_id' => 14
            ],
            [            
                'id' => 14,
                'statement' => 'Steven is anxious about his physical and mental health.;The Doctor is trying to help Steven.;Steven looks healthy and buff.;The Doctor is worried about Steven.',
                'answer' => null,
                'image_name' => null,
                'audio_name' => 'dictation_cloze.mp3',
                'correct_answer' => 'I, II & III',
                'exercise_id' => 12
            ],
            [
                'id' => 15,
                'statement' => "Have you experienced your heart racing and/or your muscles tense because you are anxious?",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 15
            ],
            [
                'id' => 16,
                'statement' => "Imagine Steven is your friend and he is feeling bad. What do you want to tell him to make him feel better? Read the examples and write a message for him.",
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 17
            ],
            [
                'id' => 18,
                'statement' => "Doctor",
                'answer' => null,
                'image_name' => 'Doctor.jpg',
                'audio_name' => 'Doctor.mp3',
                'correct_answer' => 'ASD',
                'exercise_id' => 16
            ],
            [
                'id' => 19,
                'statement' => "Steven",
                'answer' => null,
                'image_name' => 'Steven.jpg',
                'audio_name' => 'Steven.mp3',
                'correct_answer' => 'ASD',
                'exercise_id' => 16
            ],
            [            
                'id' => 20,
                'statement' => "Not wrong... it's that adverse childhood experiences or childhood ;; can have a lasting impact on how your body ;; to stress. This can affect your social, emotional, and physical development. When humans are in crisis, the brain releases the ;; cortisol, your heart races, your muscles tense... I wonder if your body is reacting to a gem equivalent of ;;. Steven, do you remember anything bad in your ;;  that particularly stuck with you?",
                'answer' => "trauma,responds,releases,cortisol,childhood",
                'image_name' => null,
                'audio_name' => 'Steven_dictation.mp3',
                'correct_answer' => 'trauma,responds,releases,cortisol,childhood',
                'exercise_id' => 18
            ],
            [            
                'id' => 21,
                'statement' => "I believe that ;; friendships are the best.",
                'image_name' => null,
                'audio_name' => null,
                'answer' => 'lasting',
                'correct_answer' => 'lasting',
                'exercise_id' => 19
            ],
            [            
                'id' => 22,
                'statement' => "I think my mom will ;; when she sees my grades.",
                'answer' => 'freak out',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 19
            ],
            [            
                'id' => 23,
                'statement' => "My sister wants to ;; soon to go out to play.",
                'answer' => 'recover',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 19
            ],
            [            
                'id' => 24,
                'statement' => "I ;; be taller than last month. ",
                'answer' => 'seem to',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 19
            ],
            [            
                'id' => 25,
                'statement' => "You have the ;; answer. It is option number 1, not 2.",
                'answer' => 'wrong',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 19
            ],
            [            
                'id' => 26,
                'statement' => "He ;; to school every morning on his bicycle.",
                'answer' => 'races',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 19
            ],
            [            
                'id' => 27,
                'statement' => "My bones ;; really well in just a few months!",
                'answer' => 'healed',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 19
            ],
            [            
                'id' => 31,
                'statement' => 'wrong',
                'answer' => 'Something that is incorrect or not true.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 11
            ],
            [            
                'id' => 32,
                'statement' => 'recover',
                'answer' => 'To become completely healthy again after an illness or injury.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'ASD',
                'exercise_id' => 11
            ],
            [            
                'id' => 33,
                'statement' => 'healed',
                'answer' => 'To make or become well again, especially after an injury.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'healed',
                'exercise_id' => 11
            ],
            [            
                'id' => 34,
                'statement' => 'seem',
                'answer' => 'To appear to be.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'seem',
                'exercise_id' => 11
            ],
            [            
                'id' => 35,
                'statement' => 'freak out',
                'answer' => 'To become or cause someone to be extremely emotional.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'freak out',
                'exercise_id' => 11
            ],
            [            
                'id' => 36,
                'statement' => 'lasting',
                'answer' => 'Something that continues to exist for a long time or forever.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'lasting',
                'exercise_id' => 11
            ],
            [            
                'id' => 37,
                'statement' => 'races',
                'answer' => 'To move or go fast.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'races',
                'exercise_id' => 11
            ],
            [            
                'id' => 93,
                'statement' => 'Response',
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'Read the statements below and check the ones that apply to you.',
                'exercise_id' => 9
            ],
            [            
                'id' => 68,
                'statement' => '1',
                'answer' => 'Complete the pre-listening exercises.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 69,
                'statement' => '2',
                'answer' => 'Check the glossary.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 70,
                'statement' => '3',
                'answer' => 'Watch the video one time.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 71,
                'statement' => '4',
                'answer' => 'Complete the while-listening exercises.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 72,
                'statement' => '5',
                'answer' => 'Complete the post-listening exercises.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],

            [            
                'id' => 73,
                'statement' => '6',
                'answer' => 'Check the transcript.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 74,
                'statement' => '7',
                'answer' => 'Watch the video two or more times.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 75,
                'statement' => '8',
                'answer' => 'Check the keywords.',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => '',
                'exercise_id' => 10
            ],
            [            
                'id' => 101,
                'statement' => 'Response',
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'How close were your predictions?',
                'exercise_id' => 988
            ],
            [            
                'id' => 102,
                'statement' => 'Response',
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'How well did you understand the text after listening for the first time? Tick the option.',
                'exercise_id' => 20
            ],
            [            
                'id' => 103,
                'statement' => 'Response',
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'Tick the option that best describes how well you did in your comprehension questions after listening to the text several times.',
                'exercise_id' => 20
            ],
            [            
                'id' => 104,
                'statement' => 'Task: Evaluating statement',
                'answer' => 'Task: Dictation cloze',
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'What problems did you experience understanding the texts you listened to in these tasks? Check (✓) all that apply.',
                'exercise_id' => 21
            ],
            [            
                'id' => 105,
                'statement' => 'In this lesson I used the following help options',
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'Think of the help options you used in this lesson and tick (✓) the options that apply to you.',
                'exercise_id' => 22
            ],
            [            
                'id' => 106,
                'statement' => 'In this lesson I used the following strategies…',
                'answer' => null,
                'image_name' => null,
                'audio_name' => null,
                'correct_answer' => 'Think of the strategies you used in this lesson and tick (✓) the options that apply to you.',
                'exercise_id' => 22
            ],
        ]);
    }
}

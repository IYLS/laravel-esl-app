<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class KeywordSeeder extends Seeder
{
    public function run()
    {
        DB::table('keywords')->truncate();
        DB::table('keywords')->insert([
            [
                'id' => 4000,
                'keyword' => '22nHTfbn8k',
                'description' => 'C5A2ArthcnhoZXnoWbEtVpBTpeY0foMQXaDJrqZa',
                'unit_id' => 764,
                'deleted_at' => null,
            ],
            [
                'id' => 4001,
                'keyword' => '1xqN17Uxxo',
                'description' => 'tddZRpEJnwOW4ISLEz3xNBY9YANvoKtNktE4IzFl',
                'unit_id' => 764,
                'deleted_at' => null,
            ],
            [
                'id' => 4018,
                'keyword' => 'relaxing',
                'description' => '(adjective) making you feel calm and comfortable. e.g. She finds acoustic guitar music very relaxing after a stressful day.',
                'unit_id' => 4002,
                'deleted_at' => null,
            ],
            [
                'id' => 4020,
                'keyword' => 'authenticity',
                'description' => '(noun) the quality of being real and true to its origins. e.g. The singer was praised for the authenticity of her live performances.',
                'unit_id' => 4002,
                'deleted_at' => null,
            ],
            [
                'id' => 4017,
                'keyword' => 'improvisation',
                'description' => '(noun) the act of creating and performing music spontaneously without preparation. e.g. The guitarist's brilliant improvisation kept the audience amazed.',
                'unit_id' => 4002,
                'deleted_at' => null,
            ],
            [
                'id' => 4019,
                'keyword' => 'conflict',
                'description' => '(noun) a clash between different forces, ideas, or people. e.g. The conflict between traditional and modern styles made the band's sound more exciting.',
                'unit_id' => 4002,
                'deleted_at' => null,
            ],
            [
                'id' => 4007,
                'keyword' => 'to goof everybody up',
                'description' => '(verb phrase) making mistakes that affect or bother a group of peoplee.g. Her mistake in the schedule goofed up the whole team.',
                'unit_id' => 4001,
                'deleted_at' => null,
            ],
            [
                'id' => 4005,
                'keyword' => 'clarinet',
                'description' => '(noun) a woodwind instrument with a single-reed mouthpiece, a cylindrical tube with a flared end, and holes stopped by keys. e.g. She plays the clarinet in the school band every Friday.',
                'unit_id' => 4001,
                'deleted_at' => null,
            ],
            [
                'id' => 4026,
                'keyword' => 'Decapitate',
                'description' => '(verb) e.g In the past, some kings would decapitate criminals as a form of public execution.',
                'unit_id' => 4005,
                'deleted_at' => null,
            ],
            [
                'id' => 4027,
                'keyword' => 'Deprive',
                'description' => '(verb) e.g. Growing up in poverty can deprive children of educational opportunities',
                'unit_id' => 4005,
                'deleted_at' => null,
            ],
            [
                'id' => 4028,
                'keyword' => 'Discourage',
                'description' => '(verb) e.g. The negative reviews didn't discourage her from publishing her book',
                'unit_id' => 4005,
                'deleted_at' => null,
            ],
            [
                'id' => 4029,
                'keyword' => 'Quit',
                'description' => '(verb) e.g. After years of training, he almost quit the team, but his coach convinced him to stay',
                'unit_id' => 4005,
                'deleted_at' => null,
            ],
            [
                'id' => 4021,
                'keyword' => 'manager',
                'description' => '(noun) A person whose job is to arrange or find work for a singer or actor, etc.  e.g. The band's manager arranged all their concerts and made sure they arrived on time for every show.',
                'unit_id' => 4004,
                'deleted_at' => null,
            ],
            [
                'id' => 4003,
                'keyword' => 'tempo',
                'description' => '(noun) the speed at which a piece of music is played. e.g. Changing the tempo halfway through the piece gave it an unexpected but exciting twist.',
                'unit_id' => 4000,
                'deleted_at' => null,
            ],
            [
                'id' => 4004,
                'keyword' => 'track',
                'description' => '(noun) it is an individual song or recording, typically one piece of audio on an album or playlist. e.g. The album includes four previously unreleased tracks.',
                'unit_id' => 4000,
                'deleted_at' => null,
            ],
            [
                'id' => 4009,
                'keyword' => 'sunset',
                'description' => '(noun) is the time in the evening when the sun disappears below the horizon and daylight fades. It also refers to the colorful sky that often appears during this time. e.g. We sat on the beach and watched the sunset—it was orange, pink, and beautiful.',
                'unit_id' => 4001,
                'deleted_at' => null,
            ],
            [
                'id' => 4012,
                'keyword' => 'begging',
                'description' => '(verb) asking someone strongly and emotionally for something, especially when you are desperate.',
                'unit_id' => 4003,
                'deleted_at' => null,
            ],
            [
                'id' => 4013,
                'keyword' => 'business',
                'description' => '(noun) the activity of buying and selling goods and services.',
                'unit_id' => 4003,
                'deleted_at' => null,
            ],
            [
                'id' => 4014,
                'keyword' => 'degrading',
                'description' => '(adjective) making someone feel ashamed, embarrassed, or without value.',
                'unit_id' => 4003,
                'deleted_at' => null,
            ],
            [
                'id' => 4015,
                'keyword' => 'pride',
                'description' => '(noun) a feeling of pleasure and satisfaction because you or someone you know has done something good.',
                'unit_id' => 4003,
                'deleted_at' => null,
            ],
            [
                'id' => 4016,
                'keyword' => 'record label business',
                'description' => '(noun phrase) a company that produces and sells music and supports artists.',
                'unit_id' => 4003,
                'deleted_at' => null,
            ],
            [
                'id' => 4011,
                'keyword' => 'audition',
                'description' => '(noun) a short performance to show your talent, usually to try to get a role in a movie, play, or music group. e.g. She studied hard and achieved her dream of becoming a doctor.',
                'unit_id' => 4003,
                'deleted_at' => null,
            ],
            [
                'id' => 4002,
                'keyword' => 'BPM',
                'description' => '(noun) abbreviation for beats per minute: a way of showing how fast a piece of music, especially dance music, is. e.g. The app analyzes each song in your playlist and displays its BPM to help you build smooth transitions.',
                'unit_id' => 4000,
                'deleted_at' => null,
            ],
            [
                'id' => 4010,
                'keyword' => 'Jazz',
                'description' => '(noun) a type of modern music originally developed by African-American musicians, with a rhythm in which the strong notes often come before the beat. Jazz is usually improvised (= invented as it is played). e.g.: She fell in love with Jazz after hearing a street musician improvise a soulful solo on the saxophone that danced just ahead of the beat.',
                'unit_id' => 4002,
                'deleted_at' => null,
            ],
            [
                'id' => 4022,
                'keyword' => 'perform',
                'description' => '(verb) To entertain people by dancing, singing, acting, or playing music. e.g. He is performing in a local band this weekend.',
                'unit_id' => 4004,
                'deleted_at' => null,
            ],
            [
                'id' => 4006,
                'keyword' => 'to give up',
                'description' => '(phrasal verb) e.g. She didn't win the race, but she's not giving up.',
                'unit_id' => 4001,
                'deleted_at' => null,
            ],
            [
                'id' => 4008,
                'keyword' => 'notes on a page',
                'description' => '(noun phrase) music on a sheet, written on printed for people to read when laying music. e.g. The notes on the page were written perfectly.',
                'unit_id' => 4001,
                'deleted_at' => null,
            ],
            [
                'id' => 4023,
                'keyword' => 'record',
                'description' => '(verb) To store sounds or moving pictures using electronic equipment so that they can be heard or seen later.  e.g. This band recorded their first album in 2005.',
                'unit_id' => 4004,
                'deleted_at' => null,
            ],
            [
                'id' => 4025,
                'keyword' => 'Apologize',
                'description' => '(verb) e.g. She apologized sincerely after realizing her comment had offended someone.',
                'unit_id' => 4005,
                'deleted_at' => null,
            ],
            [
                'id' => 4024,
                'keyword' => 'song',
                'description' => '(noun) A usually short piece of music with words that are sung. e.g. I think this song will become a big hit next summer.',
                'unit_id' => 4004,
                'deleted_at' => null,
            ]
        ]);
    }
}

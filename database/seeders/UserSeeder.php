<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 4,
                'user_id' => 'ben_caceres',
                'name' => 'Benjamín Cáceres Ramírez',
                'age' => 24,
                'email' => 'benjamin.caceres.ra@gmail.com',
                'password' => Hash::make('isopropyl360'),
                'gender' => 'male',
                'language' => 'english',
                'role' => 'student',
                'activated' => true,
                'group_id' => 345,
            ],
            [
                'id' => 6,
                'user_id' => 'mati_caceres',
                'name' => 'Matias Caceres Ramirez',
                'age' => 24,
                'email' => 'benjamin.caceres.ra@gmail.com',
                'password' => Hash::make('isopropyl360'),
                'gender' => 'male',
                'language' => 'english',
                'role' => 'student',
                'activated' => true,
                'group_id' => 345,
            ],
            [
                'id' => 5,
                'user_id' => 'admin',
                'name' => 'Admin',
                'age' => 24,
                'email' => 'admin@iyls.com',
                'password' => Hash::make('isopropyl360'),
                'gender' => 'male',
                'language' => 'english',
                'role' => 'teacher',
                'activated' => true,
                'group_id' => 3564,
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(ProficiencyLevelSeeder::class);
        $this->call(GlossedWordSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(KeywordSeeder::class);
        $this->call(UnitSeeder::class);
    }
}

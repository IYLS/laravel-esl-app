<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $exists = DB::table('exercise_types')->where('underscore_name', 'poll')->exists();
        if (!$exists) {
            DB::table('exercise_types')->insert([
                'id' => 7,
                'name' => 'Poll',
                'underscore_name' => 'poll',
                'description' => 'Likert scale 1-7',
            ]);
        }
    }

    public function down()
    {
        DB::table('exercise_types')->where('underscore_name', 'poll')->delete();
    }
};

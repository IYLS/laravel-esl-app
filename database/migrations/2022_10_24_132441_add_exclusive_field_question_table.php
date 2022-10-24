<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('exclusive_responses')->nullable(true)->after('user_response');
        });
    }

    public function down() {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('exclusive_responses');
        });
    }
};
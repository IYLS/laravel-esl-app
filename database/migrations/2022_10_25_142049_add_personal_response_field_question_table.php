<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->boolean('personal_response')->nullable(true)->after('exclusive_responses');
        });
    }

    public function down() {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('personal_response');
        });
    }
};
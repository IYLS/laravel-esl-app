<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('heading_title')->nullable(true)->after('position');
        });
    }

    public function down() {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('heading_title');
        });
    }
};
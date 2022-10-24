<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->integer('position')->nullable(true)->after('attempts_number');
        });
    }

    public function down() {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};

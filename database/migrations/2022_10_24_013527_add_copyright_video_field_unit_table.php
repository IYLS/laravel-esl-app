<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('video_copyright')->nullable(true)->after('video_name');
        });
    }

    public function down() {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('video_copyright');
        });
    }
};
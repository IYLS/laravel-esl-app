<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->text('feedback')->nullable(true)->after('help_options');
        });
    }

    public function down() {
        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn('feedback');
        });
    }
};
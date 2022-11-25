<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->text('help_options')->nullable(true)->after('wrong_answers');
        });
    }

    public function down() {
        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn('help_options');
        });
    }
};
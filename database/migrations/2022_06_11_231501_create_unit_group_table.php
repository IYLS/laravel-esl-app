<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unit_group', function (Blueprint $table) {
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('group_id')->constrained('groups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit_group');
    }
};

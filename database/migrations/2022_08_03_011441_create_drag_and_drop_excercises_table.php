<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drag_and_drop_excercises', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('description');
            $table->string('section');
            $table->integer('unit_id');
            $table->string('type');

            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    public function down()
    {
        Schema::dropIfExists('drag_and_drop_excercises');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drag_and_drop_questions', function (Blueprint $table) {
            $table->id('id');
            $table->string('concept');
            $table->string('description');
            $table->integer('excercise_id');

            $table->foreign('excercise_id')->references('id')->on('drag_and_drop_excercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('drag_and_drop_questions');
    }
};
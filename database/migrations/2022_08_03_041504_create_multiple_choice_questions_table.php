<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('multiple_choice_questions', function (Blueprint $table) {
            $table->id('id');
            $table->integer('excercise_id');
           
            $table->foreign('excercise_id')->references('id')->on('multiple_choice_excercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('multiple_choice_questions');
    }
};

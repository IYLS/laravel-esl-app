<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fill_in_the_gaps_questions', function (Blueprint $table) {
            $table->id('id');
            $table->text('statement');
            $table->string('audio_name')->nullable(true);
            $table->string('matching_word')->nullable(true);
            $table->integer('excercise_id');
            $table->softDeletes();

            $table->foreign('excercise_id')->references('id')->on('fill_in_the_gaps_excercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fill_in_the_gaps_questions');
    }
};

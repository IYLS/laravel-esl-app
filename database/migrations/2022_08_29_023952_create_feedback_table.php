<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->string('message')->nullable(true);
            $table->string('audio_name')->nullable(true);
            $table->softDeletes();

            $table->integer('feedback_type_id')->nullable(true);
            $table->integer('exercise_id')->nullable(true);
            $table->integer('question_id')->nullable(true);
            $table->integer('alternative_id')->nullable(true);


            $table->foreign('feedback_type_id')->references('id')->on('feedback_types');
            $table->foreign('exercise_id')->references('id')->on('exercises');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('alternative_id')->references('id')->on('alternatives');
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
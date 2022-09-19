<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->text('statement');
            $table->text('answer')->nullable(true);
            $table->string('image_name')->nullable(true);
            $table->string('audio_name')->nullable(true);
            $table->softDeletes();

            $table->integer('exercise_id');

            $table->foreign('exercise_id')->references('id')->on('exercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};

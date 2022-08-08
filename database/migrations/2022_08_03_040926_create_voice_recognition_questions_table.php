<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('voice_recognition_questions', function (Blueprint $table) {
            $table->id('id');
            $table->string('image_url');
            $table->string('image_name');
            $table->string('audio_url');
            $table->string('audio_name');
            $table->string('title');
            $table->integer('excercise_id');
           
            $table->foreign('excercise_id')->references('id')->on('voice_recognition_excercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('voice_recognition_questions');
    }
};

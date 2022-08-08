<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('multiple_choice_excercises', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('description');
            $table->string('instructions')->nullable(true);
            $table->string('type');
            $table->integer('subtype');
            $table->string('image_name')->nullable(true);
            $table->string('video_name')->nullable(true);
            $table->integer('section_id');

            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    public function down()
    {
        Schema::dropIfExists('multiple_choice_excercises');
    }
};

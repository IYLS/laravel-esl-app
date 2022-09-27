<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('description')->nullable(true);
            $table->string('instructions')->nullable(true);
            $table->integer('subtype')->nullable(true);
            $table->string('image_name')->nullable(true);
            $table->string('video_name')->nullable(true);
            $table->softDeletes();

            $table->integer('section_id');
            $table->integer('exercise_type_id');

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('exercise_type_id')->references('id')->on('exercise_types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};
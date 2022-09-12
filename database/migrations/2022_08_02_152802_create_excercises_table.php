<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('excercises', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('description')->nullable(true);
            $table->string('instructions')->nullable(true);
            $table->string('subtype')->nullable(true);
            $table->string('image_name')->nullable(true);
            $table->string('video_name')->nullable(true);
            $table->softDeletes();

            $table->integer('section_id');
            $table->integer('excercise_type_id');

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('excercise_type_id')->references('id')->on('excercise_types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('excercises');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('voice_recognition_excercises', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->integer('section_id');
            $table->softDeletes();
            
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    public function down()
    {
        Schema::dropIfExists('voice_recognition_excercises');
    }
};

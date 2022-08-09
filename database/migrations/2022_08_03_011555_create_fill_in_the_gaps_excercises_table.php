<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fill_in_the_gaps_excercises', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->integer('subtype');
            $table->integer('section_id');
            
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fill_in_the_gaps_excercises');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('open_ended_questions', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->text('answer')->nullable(true);
            $table->softDeletes();
            $table->integer('excercise_id');
           
            $table->foreign('excercise_id')->references('id')->on('open_ended_excercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('open_ended_questions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('tracking', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->string('intent_number');
            $table->string('time_spent_in_minutes');
            $table->string('correct_answers');
            $table->string('wrong_ansers');
            $table->timestamps();
            $table->softDeletes();

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('exercise_id');
            $table->foreign('exercise_id')->references('id')->on('exercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};
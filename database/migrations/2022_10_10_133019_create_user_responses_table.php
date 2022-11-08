<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_responses', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->text('response');
            $table->timestamps();
            $table->softDeletes();

            $table->integer('tracking_id');
            $table->foreign('tracking_id')->references('id')->on('tracking');

            $table->integer('question_id');
            $table->foreign('question_id')->references('id')->on('questions');

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_responses');
    }
};
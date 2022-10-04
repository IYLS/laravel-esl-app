<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->string('title');
            $table->boolean('correct_alt')->nullable(true);
            $table->integer('question_id');
            $table->softDeletes();

            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alternatives');
    }
};

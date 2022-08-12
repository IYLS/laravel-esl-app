<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('multiple_choice_alternatives', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->boolean('correct_alt')->nullable(true);
            $table->integer('question_id');
            $table->softDeletes();

            $table->foreign('question_id')->references('id')->on('multiple_choice_questions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('multiple_choice_alternative');
    }
};

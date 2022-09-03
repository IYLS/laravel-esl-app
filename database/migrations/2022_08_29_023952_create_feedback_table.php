<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id');
            $table->string('message')->nullable(false);
            $table->string('audio_name')->nullable(true);
            $table->softDeletes();

            $table->integer('feedback_type_id');
            $table->integer('excercise_id');

            $table->foreign('feedback_type_id')->references('id')->on('feedback_types');
            $table->foreign('excercise_id')->references('id')->on('excercises');
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};

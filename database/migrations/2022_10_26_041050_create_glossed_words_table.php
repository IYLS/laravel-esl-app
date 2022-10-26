<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('glossed_words', function (Blueprint $table) {
            $table->id('id')->startingValue(4000);
            $table->text('word');
            $table->text('description');
            $table->integer('unit_id');
            $table->softDeletes();
            
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    public function down()
    {
        Schema::dropIfExists('glossed_words');
    }
};
